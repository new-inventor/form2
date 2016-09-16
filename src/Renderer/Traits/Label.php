<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:35
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\Form\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Template\Template;

/**
 * Class LabelRendererTrait
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 */
trait Label
{
    /**
     * @return string
     */
    public function label()
    {
        $templateStr = Config::find(['renderer'], ['templates', $this->object->getTemplate(), 'label'], $this->object->getClass(),
            '');
        $template = new Template($templateStr);
        
        return $template->getString($this);
    }
    
    /**
     * @return string
     */
    public function title()
    {
        return $this->object->getTitle();
    }
}