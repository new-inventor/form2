<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:35
 */

namespace NewInventor\Form\Abstractions;

use NewInventor\Form\Abstractions\Interfaces\NamedObjectInterface;
use NewInventor\Form\Abstractions\Interfaces\ObjectListInterface;
use NewInventor\Form\TypeChecker\TypeChecker;

class NamedObjectList extends ObjectList implements \Iterator, ObjectListInterface
{
    /**
     * @param NamedObjectInterface $object
     * @throws \Exception
     * @return $this
     */
    public function add($object)
    {
        TypeChecker::getInstance()
            ->check($object, $this->getElementClasses(), 'object')
            ->throwTypeErrorIfNotValid();
        $this->objects[$object->getName()] = $object;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $res = [];
        /**
         * @var string $name
         * @var Object $obj
         */
        foreach($this->getAll() as $name => $obj){
            $res[$name] = $obj->toArray();
        }

        return $res;
    }
}