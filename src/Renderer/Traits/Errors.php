<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:32
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Template\Template;

/**
 * Class ErrorRendererTrait
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 * @property $object
 */
trait Errors
{
    /**
     * @return string
     */
    public function errors()
    {
        $errors = $this->object->getErrors();
        if (empty($errors)) {
            return '';
        }
        
        $templateStr = Config::find(
            ['renderer'],
            ['templates', $this->object->getTemplate(), 'errors'],
            $this->object->getClass(),
            ''
        );
        $template = new Template($templateStr);
        
        return $template->getString($this, $this->object);
    }
    
    /**
     * @return string
     */
    public function errorsStr()
    {
        $errorDelimiter = Config::get(['renderer', 'errors', 'delimiter']);
        $errorsStr = implode($errorDelimiter, $this->object->getErrors());
        
        return $errorsStr;
    }
}