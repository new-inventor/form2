<?php
/**
 * User: Ionov George
 * Date: 12.02.2016
 * Time: 17:51
 */

namespace NewInventor\Form\Abstractions;

use NewInventor\Form\TypeChecker\Exception\ArgumentException;
use NewInventor\Form\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\Form\Abstractions\Interfaces\NamedObjectInterface;
use NewInventor\Form\TypeChecker\TypeChecker;

class NamedObject extends Object implements NamedObjectInterface
{
    /** @var string */
    private $name;

    /**
     * NamedObject constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setName($name)
    {
        TypeChecker::getInstance()
            ->isString($name, 'name')
            ->throwTypeErrorIfNotValid();
        $this->name = $name;

        return $this;
    }

    public static function initFromArray(array $data)
    {
        if (isset($data['name'])) {
            return new static($data['name']);
        }
        throw new ArgumentException('Имя не передано.', 'data');
    }

    public function toArray()
    {
        return [
            'name' => $this->getName()
        ];
    }

    public static function getClass()
    {
        return get_called_class();
    }
}