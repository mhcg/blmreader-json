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
}
