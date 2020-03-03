<?php


namespace Lobster\Identity;


/**
 * Interface ObjectIdGenerator
 * @package Lobster\Identity
 */
interface ObjectIdGeneratorInterface {

    /**
     * @param object $object
     * @return string
     */
    public function generate(object $object): string ;
}
