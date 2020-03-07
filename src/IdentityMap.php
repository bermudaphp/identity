<?php


namespace Lobster\Identity\Map;


use Traversable;

/**
 * Class Map
 * @package Lobster\Identity
 */
class IdentityMap implements IdentityMapInterface {

    /**
     * @var ObjectIdGeneratorInterface
     */
    private $generator;

    /**
     * @var object[]
     */
    private $objects = [];

    /**
     * IdentityMap constructor.
     * @param ObjectIdGeneratorInterface $idGenerator|null
     */
    public function __construct(ObjectIdGeneratorInterface $idGenerator = null) {
        $this->generator = $idGenerator ?? new IdGenerator();
    }

    /**
     * @param object $object
     * @return IdentityMap
     */
    public function add(object $object) : self {
        return $this->set(
            $this->generator->generate($object),
            $object
        );
    }

    /**
     * @param object $object
     * @param string|null $id
     * @return IdentityMap
     */
    public function set(object $object, string $id = null) : self {
        
        if($id == null){
            $id = $this->generator->generate($object);
        }
        
        $this->objects[$id] = $object;
        
        return $this;
    }

    /**
     * @param object[] $objects
     * @param ObjectIdGeneratorInterface|null $idGenerator
     * @return IdentityMap
     */
    public static function from(
        array $objects,
        ObjectIdGeneratorInterface $idGenerator = null
    ) : self {
        
        $map = new static($idGenerator);
        
        foreach ($objects as $obj){
            $map->add($obj);
        }
        
        return $map;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id) : bool {
        return array_key_exists($id, $this->objects);
    }

    /**
     * @param string $id
     * @return object|null
     */
    public function get(string $id) :? object {
        return $this->objects[$id] ?? null;
    }

    /**
     * @param string $id
     * @return IdentityMap
     */
    public function remove(string $id) : self {
        unset($this->objects[$id]);
    }

    /**
     * @param object $obj
     * @return IdentityMap
     */
    public function removeObject(object $obj) : self {
        return $this->remove(
            (string) $this->idOf($obj)
        );
    }

    /**
     * @param object $object
     * @return string|null
     */
    public function idOf(object $object) :? string {
        
        foreach ($this->objects as $id => $obj){
            if($object === $obj){
                return $id;
            }
        }

        return null;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function hasObject(object $object) : bool {
        return $this->idOf($object) !== null;
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator() {
        return new \ArrayIterator($this->objects);
    }
}
