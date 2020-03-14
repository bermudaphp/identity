<?php


namespace Lobster\Identity\Map;


use ArrayIterator;


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
     * @param string $id
     * @param object $object
     * @return IdentityMap
     */
    public function set(string $id, object $object) : self {
        
        $cls = get_class($object);
        
        if($this->has($cls, $id)){
            throw DuplicateException::new($cls, $id);
        }
        
        $this->objects[$cls][$id] = $object;
        
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
     * @param string $cls
     * @param string $id
     * @return bool
     */
    public function has(string $cls, string $id) : bool {
        return array_key_exists($id, $this->objects[$cls] ?? []);
    }

    /**
     * @param string $cls
     * @param string $id
     * @return object|null
     */
    public function get(string $cls, string $id) :? object {
        return $this->objects[$cls][$id] ?? null;
    }

    /**
     * @param string $cls
     * @param string $id
     * @return IdentityMap
     */
    public function remove(string $cls, string $id) : self {
        unset($this->objects[$cls][$id]);
    }

    /**
     * @param object $obj
     * @return IdentityMap
     */
    public function removeObject(object $obj) : self {
        return $this->remove(
            get_class($obj), (string) $this->idOf($obj)
        );
    }

    /**
     * @param object $object
     * @return string|null
     */
    public function idOf(object $object) :? string {

        foreach ($this->objects[get_class($object)] ?? [] as $id => $obj){
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
     * @inheritDoc
     */
    public function getIterator() : ArrayIterator {
        return new ArrayIterator($this->objects);
    }
}
