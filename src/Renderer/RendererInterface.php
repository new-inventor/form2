<?php

namespace NewInventor\Form\Renderer;

use NewInventor\Form\Abstractions\Interfaces\ObjectInterface;

interface RendererInterface
{
    /**
     * @return string
     */
    public function getString();

    /**
     * @return string
     */
    public function __toString();

    public function render();
}