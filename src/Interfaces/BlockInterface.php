<?php

namespace NewInventor\Form\Interfaces;

use NewInventor\Form\Field\Select;
use NewInventor\Form\Field\TextArea;
use NewInventor\Form\Field\CheckBoxSet;
use NewInventor\Form\Renderer\RenderableInterface;
use NewInventor\Form\Validator\Interfaces\ValidatableInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

interface BlockInterface extends FormObjectInterface, RenderableInterface, ValidatableInterface
{
    /**
     * @param string $name
     *
     * @return BlockInterface
     */
    public function block($name);
    
    /**
     * @param BlockInterface|FieldInterface $object
     *
     * @return BlockInterface|FormInterface
     * @throws ArgumentTypeException
     */
    public function repeatable($object);
    
    /**
     * @param FieldInterface $field
     *
     * @return FieldInterface
     */
    public function field($field);
    
    /**
     * @param array $data
     *
     * @return bool
     */
    public function load($data = null);
    
    /**
     * @return bool
     */
    public function isRepeatableContainer();
    
    /**
     * @param $repeatable
     *
     * @return $this
     */
    public function setRepeatable($repeatable);
    
    /**
     * @return $this
     */
    public function clear();
    
    /**
     * @return BlockInterface|FieldInterface
     */
    public function getRepeatObject();
    
    /**
     * @param BlockInterface|FieldInterface $repeatObject
     */
    public function setRepeatObject($repeatObject);
    
    /**
     * @return array
     */
    public function getValue();
}