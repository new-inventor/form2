<?php
/**
 * User: Ionov George
 * Date: 23.03.2016
 * Time: 14:47
 */

namespace NewInventor\Form\Renderer;

use NewInventor\Form\Abstractions\Interfaces\ObjectInterface;
use NewInventor\Form\Abstractions\Object;
use NewInventor\Form\Patterns\SingletonTrait;

class BaseRenderer extends Object implements RendererInterface
{
    use SingletonTrait;
    
    protected static $borders;
    public $object;
    protected $params;

    /**
     * BaseRenderer constructor.
     * @param ObjectInterface $object
     * @param array $params
     */
    public function __construct(ObjectInterface $object, array $params = [])
    {
        $this->object = $object;
        $this->params = $params;
    }

    /** @inheritdoc */
    public function render()
    {
        echo $this->getString();
    }

    /** @inheritdoc */
    public function getString()
    {
        return '';
    }

    /** @inheritdoc */
    public function __toString()
    {
        return $this->getString();
    }
}