<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:44
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Template\Template;
use NewInventor\TypeChecker\TypeChecker;

/**
 * Class Repeatable
 * @package NewInventor\Form\Renderer\Traits
 *
 * @method getReplacements(array $placeholders, $object)
 */
trait Repeatable
{
    /**
     * @param bool $check
     *
     * @return string
     */
    public function actions($check = true)
    {
        $templateStr = Config::get(['renderer', 'templates', $this->block->getTemplate(), 'repeatActionsBlock']);
        $template = new Template($templateStr);
        
        return $template->getString($this, $check);
    }
    
    /**
     * @param BlockInterface|FieldInterface $block
     * @param bool $check
     *
     * @return string
     */
    public function addButton($check = true)
    {
        $res = '';
        if (((int)$this->block->getName() == count($this->block->getParent()->children()) - 1) || !$check) {
            $templateStr = Config::get(['renderer', 'templates', $bthis->lock->getTemplate(), 'addButton']);
            $template = new Template($templateStr);
            $res = $template->getString($this);
        }
        
        return $res;
    }
    
    /**
     * @param bool $check
     *
     * @return string
     */
    public function deleteButton($check = true)
    {
        $res = '';
        if (((int)$this->block->getName() != 0 || count($this->block->getParent()->children()) > 1) || !$check) {
            $templateStr = Config::get(['renderer', 'templates', $this->block->getTemplate(), 'deleteButton']);
            $template = new Template($templateStr);
            $res = $template->getString($this);
        }
        
        return $res;
    }
    
    public function blockSelector()
    {
        return $this->getSelectorFromSettings('block');
    }
    
    public function containerSelector()
    {
        return $this->getSelectorFromSettings('container');
    }
    
    public function actionsBlockSelector()
    {
        return $this->getSelectorFromSettings('actionsBlock');
    }
    
    public function deleteActionSelector()
    {
        return $this->getSelectorFromSettings('deleteAction');
    }
    
    public function addActionSelector()
    {
        return $this->getSelectorFromSettings('addAction');
    }
    
    public function getSelectorFromSettings($type = '')
    {
        if (empty($type)) {
            return '';
        }
        
        $selector = Config::get(['renderer', 'repeat', $type], '');
        TypeChecker::getInstance()->isString($selector, 'selector')->throwTypeErrorIfNotValid();
        
        return $selector;
    }
    
    /**
     * @return string
     */
    public function name()
    {
        return $this->object->getParent()->getName();
    }
}