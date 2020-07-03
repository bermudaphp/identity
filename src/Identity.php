<?php


namespace Bermuda\Identity;


/**
 * Class Identity
 * @package Bermuda\Identity
 */
class Identity implements IdentityInterface
{
    /**
     * @var object[]
     */
    private array $objects = [];
    private GeneratorInterface $generator;

    public function __construct(GeneratorInterface $generator = null) 
    {
        $this->generator = $generator ?? new Generator();
    }

    /**
     * @param object $object
     * @throws InvalidObjectException
     * @throws DuplicateObjectException
     * @return Identity
     */
    public function add(object $object): IdentityInterface 
    {    
        $id = $this->generator->generate($object);
        
        if($id == null)
        {
            throw IdentityException::fromObject($object);
        }
        
        return $this->set($id, $object);
    }

    /**
     * @param string $id
     * @param object $object
     * @throws DuplicateObjectException
     * @return IdentityMap
     */
    public function set(string $id, object $object): IdentityInterface
    {    
        $cls = get_class($object);
        
        if($this->has($cls, $id))
        {
            throw IdentityException::duplicate($object, $id);
        }
        
        $this->objects[$cls][$id] = $object;
        return $this;
    }

    /**
     * @param object[] $objects
     * @param GeneratorInterface|null $generator
     * @return static
     */
    public static function create(array $objects, GeneratorInterface $generator = null): self 
    {
        $identity = new static($generator);

        foreach ($objects as $obj)
        {
            $identity->add($obj);
        }

        return $identity;
    }

    /**
     * @param string $cls
     * @param string $id
     * @return bool
     */
    public function has(string $cls, string $id): bool 
    {
        return array_key_exists($id, $this->objects[$cls] ?? []);
    }

    /**
     * @param string $cls
     * @param string $id
     * @return object|null
     */
    public function get(string $cls, string $id):? object 
    {
        return $this->objects[$cls][$id] ?? null;
    }

    /**
     * @param string $cls
     * @param string $id
     * @return IdentityMap
     */
    public function remove(string $cls, string $id): IdentityInterface 
    {
        unset($this->objects[$cls][$id]);
    }

    /**
     * @param object $obj
     * @return IdentityMap
     */
    public function removeObject(object $obj): IdentityInterface 
    {
        return $this->remove(get_class($obj), (string) $this->idOf($obj));
    }

    /**
     * @param object $object
     * @return string|null
     */
    public function idOf(object $object):? string 
    {
        foreach ($this->objects[get_class($object)] ?? [] as $id => $obj)
        {
            if($object === $obj)
            {
                return $id;
            }
        }

        return null;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function hasObject(object $object): bool 
    {
        return $this->idOf($object) !== null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \Generator 
    {
        foreach($this->objects as $object)
        {
            yield $object;
        }
    }
}
