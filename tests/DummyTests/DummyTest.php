<?php

/**
 * Dummy Test file.
 *
 * @package Dummy
 */

declare(strict_types=1);

namespace MHCG\BLMReaderJsonTests;

use PHPUnit\Framework\TestCase;
use MHCG\BLMReaderJson\DummyClass;

/**
 * Dummy Test class.
 */
class DummyTest extends TestCase
{
    /**
     * Dummy test - does nothing.
     *
     * @return void
     */
    public function testFunction()
    {
        // Assert.
        $result = DummyClass::returnTrue();
        $this->assertTrue($result);
    }
}
