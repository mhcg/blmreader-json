<?php

/**
 * Property Address Object.
 *
 * @package MHCG\BLMReaderJson\Objects
 */

declare(strict_types=1);

namespace MHCG\BLMReaderJson\Objects;

/**
 * Property Address Object.
 */
final class PropertyAddress
{
    /**
     * ADDRESS_1.
     *
     * @var string
     */
    public string $address1;

    /**
     * ADDRESS_2.
     *
     * @var string
     */
    public string $address2;

    /**
     * ADDRESS_3.
     *
     * @var string
     */
    public ?string $address3;

    /**
     * ADDRESS_4.
     *
     * @var string
     */
    public ?string $address4;

    /**
     * TOWN.
     *
     * @var string
     */
    public string $town;

    /**
     * POSTCODE1.
     *
     * @var string
     */
    public string $postcode1;

    /**
     * POSTCODE2.
     *
     * @var string
     */
    public string $postcode2;

    /**
     * Create a Property Address.
     *
     * @param string $address1  ADDRESS_1.
     * @param string $address2  ADDRESS_2.
     * @param string $address3  ADDRESS_3.
     * @param string $address4  ADDRESS_4.
     * @param string $town      TOWN.
     * @param string $postcode1 POSTCODE1.
     * @param string $postcode2 POSTCODE2.
     *
     * @throws \InvalidArgumentException If a required field is missing.
     */
    public function __construct(
        string $address1,
        string $address2,
        ?string $address3,
        ?string $address4,
        string $town,
        string $postcode1,
        string $postcode2
    ) {
        // Sanity check.
        if (empty($address1)) {
            throw new \InvalidArgumentException('Address1 is required.');
        }
        if (empty($address2)) {
            throw new \InvalidArgumentException('Address2 is required.');
        }
        if (empty($town)) {
            throw new \InvalidArgumentException('Town is required.');
        }
        if (empty($postcode1)) {
            throw new \InvalidArgumentException('Postcode1 is required.');
        }
        if (empty($postcode2)) {
            throw new \InvalidArgumentException('Postcode2 is required.');
        }

        $this->address1  = $address1;
        $this->address2  = $address2;
        $this->address3  = $address3;
        $this->address4  = $address4;
        $this->town      = $town;
        $this->postcode1 = $postcode1;
        $this->postcode2 = $postcode2;
    }
}
