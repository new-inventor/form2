<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:38
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FormInterface;

trait Children
{
    /**
     * @return string
     */
    public function children()
    {
        return implode('', $this->object->children()->getAll());
    }
}