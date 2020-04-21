<?php

declare(strict_types=1);

namespace MHCG\BLMReaderJsonTests;

use PHPUnit\Framework\TestCase;
use MHCG\BLMReaderJson\BLMToJSON;
use EnricoStahn\JsonAssert\Assert as JsonAssert;

final class BLMToJSONTest extends TestCase
{
    use JsonAssert;

    /**
     * Returns a valid BLM file(name).
     *
     * @return string
     */
    private static function validFile(): string
    {
        return dirname(__FILE__) . '/valid.blm';
    }

    /**
     * Returns an invalid BLM file(name) - structure missing from file.
     *
     * @return string
     */
    private static function invalidFileMissingStructure(): string
    {
        return dirname(__FILE__) . '/invalidstructure.blm';
    }

    /**
     * Returns an invalid BLM file(name) - structure TOWN field.
     *
     * @return string
     */
    private static function invalidFileMissingField(): string
    {
        return dirname(__FILE__) . '/invalidmissing.blm';
    }

    /**
     * Returns JSON Schema filename.
     *
     * @return string
     */
    private static function jsonSchemaFile(): string
    {
        return dirname(__FILE__) . '/../schema.json';
    }

    public function testCreateFromValidFile()
    {
        // TODO: Find example of valid BLM file.
        $this->assertInstanceOf(
            BLMToJSON::class,
            BLMToJSON::fromFile(self::validFile())
        );
    }

    public function testCannotCreateFromFileNotFound()
    {
        $this->expectExceptionMessageMatches('/not found/i');
        BLMToJSON::fromFile('File_Does_Not_Exist.zzz');
        $this->expectException(\InvalidArgumentException::class);
        BLMToJSON::fromFile('File_Does_Not_Exist.zzz');
    }

    public function testCannotCreateFromInvalidFileStructure()
    {
        $this->expectException(\InvalidArgumentException::class);
        BLMToJSON::fromFile(self::invalidFileMissingStructure());
    }

    public function testCannotCreateFromInvalidFileMissingField()
    {
        $this->expectException(\InvalidArgumentException::class);
        BLMToJSON::fromFile(self::invalidFileMissingField());
        $this->expectExceptionMessageMatches('/TOWN/');
        BLMToJSON::fromFile(self::invalidFileMissingField());
    }

    public function testOutputValidJson()
    {
        $blm = BLMToJSON::fromFile(self::validFile());
        $json = $blm->asJson();
        $this->assertJsonMatchesSchema($json, $this->jsonSchemaFile());
    }
}
