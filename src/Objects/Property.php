<?php

/**
 * Property Object.
 *
 * @package MHCG\BLMReaderJson\Objects
 */

declare(strict_types=1);

namespace MHCG\BLMReaderJson\Objects;

/**
 * Property Object.
 */
final class Property
{
    /**
     * AGENT_REF.
     *
     * @var string
     */
    public string $agentRef;

    /**
     * Address object.
     *
     * @var PropertyAddress
     */
    public PropertyAddress $propertyAddress;

    /**
     * Standard constructor - needs an Agent Ref.
     *
     * @param string $agentRef AGENT_REF.
     *
     * @throws \InvalidArgumentException When AGENT_REF is missing.
     */
    public function __construct(string $agentRef)
    {
        if (empty($agentRef)) {
            throw new \InvalidArgumentException('Agent Ref cannot be empty.');
        }

        $this->agentRef = $agentRef;
    }

    /**
     * Set Property Address.
     *
     * @param string $address1  ADDRESS_1.
     * @param string $address2  ADDRESS_2.
     * @param string $address3  ADDRESS_3.
     * @param string $address4  ADDRESS_4.
     * @param string $town      TOWN.
     * @param string $postcode1 POSTCODE1.
     * @param string $postcode2 POSTCODE2.
     *
     * @return void
     *
     * @throws \InvalidArgumentException When ADDRESS_1/2, TOWN or POSTCODE1/2 are missing.
     */
    public function setPropertyAddress(
        string $address1,
        string $address2,
        ?string $address3,
        ?string $address4,
        string $town,
        string $postcode1,
        string $postcode2
    ) {
        $this->propertyAddress = new PropertyAddress(
            $address1,
            $address2,
            $address3,
            $address4,
            $town,
            $postcode1,
            $postcode2
        );
    }
}
