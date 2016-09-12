<?php

namespace NewInventor\Form\Interfaces;


use NewInventor\TypeChecker\Exception\ArgumentTypeException;

interface FormInterface extends BlockInterface
{
    /**
     * @return string
     */
    public function getAction();
    
    /**
     * @param string $action
     *
     * @return FormInterface
     * @throws ArgumentTypeException
     */
    public function action($action);
    
    /**
     * @return string
     */
    public function getEncType();
}