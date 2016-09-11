<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 21:43
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\HandlerInterface;
use NewInventor\Template\Template;

class HandlerRenderer extends FieldRenderer
{
    use Traits\Attributes;
    
    /** @inheritdoc */
    public function render(ObjectInterface $handler)
    {
        /** @var HandlerInterface $handler */
        $templateStr = Config::get(['renderer', 'templates', $handler->getTemplate(), 'handler']);
        $template = new Template($templateStr);
        
        return $template->getString($this, $handler);
    }
    
    public function handler(HandlerInterface $handler)
    {
        return $this->input($handler->attribute('type', 'submit'));
    }
}