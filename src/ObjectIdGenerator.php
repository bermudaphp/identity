<?php


namespace Lobster\Identity;


/**
 * Class ObjectIdGenerator
 * @package Lobster\Identity
 */
class ObjectIdGenerator implements ObjectIdGeneratorInterface {

    /**
     * @param object $object
     * @return string
     */
    public function generate(object $object) : string {
        return spl_object_hash($object);
    }
}
