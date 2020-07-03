<?php


namespace Bermuda\Identity;


/**
 * Class Generator
 * @package Bermuda\Identity
 */
class Generator implements ObjectIdGeneratorInterface 
{
    /**
     * @param object $object
     * @return string
     */
    public function generate(object $object): string 
    {
        return spl_object_hash($object);
    }
}
