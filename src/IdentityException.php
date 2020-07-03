<?php


namespace Bermuda\Identity;


/**
 * Class IdentityException
 * @package Bermuda\Identity
 */
class IdentityException extends \RuntimeException
{
    /**
     * @param string $cls
     * @param string $id
     * @return self
     */
    public static function duplicate(string $cls, string $id): self
    {
        return new static(sprintf('An instance of the %s class with id: %s is already contained in the map', $cls, $id));
    }
}
