<?php

/**
 * Converts a BLM (RightMove) file to JSON.
 *
 * @package MHCG\BLMReaderJsonTests
 * @author  MHCG LTD <contact@mhcg.co.uk>
 * @license https://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

declare(strict_types=1);

namespace MHCG\BLMReaderJson;

use BLM\Reader as BLMReader;
use MHCG\BLMReaderJson\Objects\{Property,PropertyAddress};

/**
 * Takes a BLM (RightMove) array containing fields from a BLM file and convert to JSON.
 */
final class BLMToJSON
{
    /**
     * Array to use for the conversion.
     *
     * @var array
     */
    private ?array $blmArray = null;

    /**
     * Create a converter using a BLM array.
     *
     * @param array $blmArray Array containing BLM fields.
     *
     * @throws \InvalidArgumentException When specific array does not contain a valid BLM structure.
     */
    public function __construct(array $blmArray)
    {
        self::validateArray($blmArray);
        $this->blmArray = $blmArray;
    }

    /**
     * Returns a new instance using a BLM file.
     *
     * @param string $blmFile Filename for the BLM file to be used.
     *
     * @throws \InvalidArgumentException When specific file does not contain valid BLM data.
     *
     * @return BLMToJSON::class
     */
    public static function fromFile(string $blmFile)
    {
        // Sanity check first.
        if (!file_exists($blmFile)) {
            throw new \InvalidArgumentException('Specific file (' . $blmFile . ') not found.');
        }

        // Re-throw errors from BLMReader as specifically want InvalidArgumentException.
        try {
            $blmReader = new BLMReader($blmFile);
            $obj = new BLMToJSON($blmReader->toArray());
        } catch (\Exception $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        }
        return $obj;
    }

    /**
     * Returns a new instance using an array containing BLM fields.
     *
     * @param array $blmArray Array containing BLM fields.
     *
     * @throws \InvalidArgumentException When specific array does not contain a valid BLM structure.
     *
     * @return BLMToJSON::class
     */
    public static function fromArray(array $blmArray)
    {
        $obj = new BLMToJSON($blmArray);
        return $obj;
    }

    /**
     * Returns the JSON for BLM V3.
     *
     * @return string Containing JSON.
     */
    public function asJSON()
    {
        // Build the JSON array.
        $propertiesArray = [];
        foreach ($this->blmArray as $property) {
            $property = $this->blmArray[0];

            $propertyObject  = new Property($property['AGENT_REF'] ?: '');
            $propertyObject->propertyAddress = new PropertyAddress(
                $property['ADDRESS_1'] ?: '',
                $property['ADDRESS_2'] ?: '',
                $property['ADDRESS_3'] ?: '',
                $property['ADDRESS_4'] ?: '',
                $property['TOWN'] ?: '',
                $property['POSTCODE1'] ?: '',
                $property['POSTCODE2'] ?: '',
            );

            $propertiesArray[] = $propertyObject;
        }
        $jsonArray = ['properties' => $propertiesArray];

        return \json_encode($jsonArray);
    }

    /**
     * Helper function to validate BLM array.
     *
     * Checks the specififed array is a valid BLM array.
     *
     * @param array $blmArray Array containing BLM fields.
     *
     * @throws \InvalidArgumentException When specific array does not contain a valid BLM structure.
     *
     * @return void If everything is fine, exception gets thrown otherwise.
     */
    private static function validateArray(array $blmArray)
    {
        if (0 === count($blmArray)) {
            throw new \InvalidArgumentException("Invalid BLM array passed - nothing found.");
        }

        // Assume first row (if there is one) is the same as the request
        // and check for required fields.
        $firstProperty = $blmArray[0];
        $missingFields = [];
        foreach (self::requiredFields() as $required) {
            if (!\array_key_exists($required, $firstProperty)) {
                $missingFields[] = $required;
            }
        }

        // Throw on one or more missing fields.
        if (0 !== count($missingFields)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    "Missing required fields: %s.",
                    \implode(', ', $missingFields)
                )
            );
        }
    }

    /**
     * List of required fields from the BLM docs.
     *
     * @link https://www.rightmove.co.uk/ps/pdf/guides/RightmoveDatafeedFormatV3iOVS_1.6.pdf
     *
     * @return array Array containing all required field names from the BLM format.
     */
    protected static function requiredFields(): array
    {
        $result = [];
        $result[] = 'AGENT_REF';
        $result[] = 'ADDRESS_1';
        $result[] = 'ADDRESS_2';
        $result[] = 'TOWN';
        $result[] = 'POSTCODE1';
        $result[] = 'POSTCODE2';
        $result[] = 'FEATURE1';
        $result[] = 'FEATURE2';
        $result[] = 'FEATURE3';
        $result[] = 'SUMMARY';
        $result[] = 'DESCRIPTION';
        $result[] = 'BRANCH_ID';
        $result[] = 'STATUS_ID';
        $result[] = 'BEDROOMS';
        $result[] = 'PRICE';
        $result[] = 'PROP_SUB_ID';
        $result[] = 'DISPLAY_ADDRESS';
        $result[] = 'PUBLISHED_FLAG';
        $result[] = 'TRANS_TYPE_ID';
        $result[] = 'MEDIA_IMAGE_00';
        return $result;
    }
}
