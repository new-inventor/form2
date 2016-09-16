<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 17.09.2016
 * Time: 1:06
 */

namespace NewInventor\Form;


trait RenderTrait
{
    /**
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getString();
        } catch (\Exception $e) {
            return "{$e->getMessage()}. File: {$e->getFile()}, Line: {$e->getLine()}, Stack trace: {$e->getTraceAsString()}";
        }
    }

    /**
     * Echo string
     */
    public function render()
    {
        echo $this->getString();
    }

    /**
     * @return string
     */
    abstract public function getString();
}