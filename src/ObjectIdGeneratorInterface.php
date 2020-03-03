<?php


namespace Lobster\Identity;


/**
 * Interface ObjectIdGenerator
 * @package Halcyon\ORM
 */
interface ObjectIdGeneratorInterface {

    /**
     * @param object $object
     * @return string
     */
    public function generate(object $object): string ;
}
