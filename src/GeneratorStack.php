<?php


namespace Bermuda\Identity;


/**
 * Class StackGenerator
 * @package Bermuda\Identity
 */
class GeneratorStack implements ObjectIdGeneratorInterface 
{
    /**
     * @var ObjectIdGeneratorInterface[]
     */
    private array $generators = [];

    public function __construct(array $generators = [])
    {
        foreach ($generators as $generator)
        {
            $this->add($generator);
        }
    }

    /**
     * @param ObjectIdGeneratorInterface $generator
     * @return StackGenerator
     */
    public function add(ObjectIdGeneratorInterface $generator): self 
    {
        $this->generators[] = $generator;
        return $this;
    }
    
    /**
     * @param object $object
     * @return string
     */
    public function generate(object $object):? string 
    {    
        foreach ($this->generators as $generator)
        {
            if(($id = $generator->generate($object)) != null)
            {
                return $id;
            }
        }
        
        return null;
    }
}
