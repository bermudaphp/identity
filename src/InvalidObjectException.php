<?php


namespace Lobster\Identity;


/**
 * Class IvalidObjectException
 * @package Lobster\Identity
 */
class InvalidObjectException extends \Exception {

    /**
     * @param object $obj
     * @return InvalidObjectException
     */
    public static function new(object $obj) : self {
        return new static(
            sprintf('Cannot generate an id for an object of class %s', get_class($obj))
        );
    }
}
