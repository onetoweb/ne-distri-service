<?php

namespace Onetoweb\NeDistriService;

use DateTime;

/**
 * Ne DistriService Token
 */
class Token
{
    /**
     * @param string $value
     * @param DateTime $expires
     */
    public function __construct(
        private string $value,
        private DateTime $expires
    ) {
        
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
    
    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * @return string
     */
    public function getExpires(): DateTime
    {
        return $this->expires;
    }
    
    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return (bool) $this->expires < new DateTime();
    }
}
