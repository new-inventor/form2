<?php
/**
 * User: Ionov George
 * Date: 23.03.2016
 * Time: 14:47
 */

namespace NewInventor\Form\Renderer;

use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\Abstractions\Object;
use NewInventor\Patterns\SingletonTrait;

class BaseRenderer extends Object implements RendererInterface
{
    use SingletonTrait;
    const FIELD = 'field';
    const BLOCK = 'block';
    const FORM = 'form';
    
    protected static $borders;
    
    public function __construct()
    {
    }
    
    /** @inheritdoc */
    public function render(ObjectInterface $object)
    {
        return '';
    }
}