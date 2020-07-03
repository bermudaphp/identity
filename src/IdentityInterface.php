<?php


namespace Bermuda\Identity;


/**
 * interface IdentityInterface
 * @package Bermuda\Identity
 */
interface IdentityInterface extends \IteratorAggregate 
{
    /**
     * @param object $object
     * @throws IdentityException
     * @return IdentityInterface
     */
    public function add(object $object): self ;
    
    /**
     * @param string $cls
     * @param object $object
     * @throws IdentityException
     * @return IdentityInterface
     */
    public function set(string $cls, object $object): self ;

    /**
     * @param string $cls
     * @param string $id
     * @return bool
     */
    public function has(string $cls, string $id): bool ;
    
    /**
     * @param string $cls
     * @param string $id
     * @return object|null
     */
    public function get(string $cls, string $id):? object ;

    /**
     * @param string $cls
     * @param string $id
     * @return IdentityMap
     */
    public function remove(string $cls, string $id): self ;

    /**
     * @param object $obj
     * @return IdentityMap
     */
    public function removeObject(object $obj): self ;

    /**
     * @param object $object
     * @return string|null
     */
    public function idOf(object $object):? string ;
    
    /**
     * @param object $object
     * @return bool
     */
    public function hasObject(object $object): bool ;
}
