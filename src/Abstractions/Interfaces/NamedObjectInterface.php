<?php
/**
 * User: Ionov George
 * Date: 11.02.2016
 * Time: 8:59
 */

namespace NewInventor\Form\Abstractions\Interfaces;

interface NamedObjectInterface extends ObjectInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);
}