<?php


namespace Lobster\Identity;


/**
 * Class DuplicateObjectException
 * @package Lobster\Identity
 */
class DuplicateObjectException extends \Exception {

    /**
     * @param string $cls
     * @param string $id
     * @return DuplicateObjectException
     */
    public static function new(string $cls, string $id) : self {
        return new static(
            sprintf('An instance of the %s class with id: %s is already contained in the map', $cls, $id)
        );
    }
}
