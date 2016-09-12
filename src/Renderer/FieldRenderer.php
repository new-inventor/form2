<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:42
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Abstraction\KeyValue;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Field;
use NewInventor\Form\Interfaces\FormObjectInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;

class FieldRenderer extends BaseRenderer
{
    use Traits\Attributes;
    use Traits\Label;
    use Traits\Errors;
    use Traits\Repeatable;
    
    /** @inheritdoc */
    public function getString()
    {
        /** @var FieldInterface $field */
        if ($this->object->isRepeatable()) {
            $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'repeatFiled']);
        } else {
            $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'field']);
        }
        $template = new Template($templateStr);
        
        return $template->getString($this);
    }
    
    public function forField()
    {
        return 'for="' . $this->object->getId() . '"';
    }
    
    /**
     * @return string
     */
    public function field()
    {
        $fieldStr = '';
        if ($this->object instanceof Field\CheckBox) {
            $fieldStr = $this->checkBox($this->object);
        } elseif ($this->object instanceof Field\Select) {
            $fieldStr = $this->select($this->object);
        } elseif ($this->object instanceof Field\CheckBoxSet) {
            $fieldStr = $this->checkSet($this->object);
        } elseif ($this->object instanceof Field\Input) {
            $fieldStr = $this->input($this->object);
        } elseif ($this->object instanceof Field\RadioSet) {
            $fieldStr = $this->checkSet($this->object);
        } elseif ($this->object instanceof Field\TextArea) {
            $fieldStr = $this->textArea($this->object);
        }
        
        return $fieldStr;
    }
    
    public function checkBox()
    {
        $checked = $this->object->getValue() ? ' checked' : '';
        
        return "<input {$this->attributes($this->object)}{$checked} />";
    }
    
    /**
     * @return string
     */
    public function checkSet()
    {
        $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'checkSet']);
        $template = new Template($templateStr);
        
        return $template->getString($this);
    }
    
    public function options()
    {
        $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'checkSetOption']);
        $template = new Template($templateStr);
        $options = '';
        foreach ($this->object->options() as $option) {
            $options .= $template->getString($this, $option);
        }
        
        return $options;
    }
    
    /**
     * @param array $placeholders
     * @param array $option
     *
     * @return array
     */
    public function getOptionReplacements(array $placeholders, array $option)
    {
        $res = [];
        foreach ($placeholders as $placeholder) {
            $res[] = $this->$placeholder($this->object, $option);
        }
        
        return $res;
    }
    
    public function option(array $option = [])
    {
        $checked = $this->object->optionSelected($option['value']) ? ' checked' : '';
        
        $res = /** @lang text */
            "<input {$this->renderOptionAttributes()} value=\"{$option['value']}\"{$checked} />";
        
        return $res;
    }
    
    public function renderOptionAttributes()
    {
        $asArray = '';
        $type = '';
        if ($this->object instanceof Field\CheckBoxSet) {
            $type = 'checkbox';
            $asArray = '[]';
        } elseif ($this->object instanceof Field\RadioSet) {
            $type = 'radio';
        }
        $type = new AttributeRenderer(new KeyValue('type', $type));
        $name = new AttributeRenderer(new KeyValue('name', $this->object->getFullName() . $asArray));
        $attrs = [$type->render(), $name->render()];
        foreach ($this->object->attributes() as $attr) {
            $renderer = new AttributeRenderer($attr);
            $attrs[] = $renderer->render();
        }
        
        return implode(' ', $attrs);
    }
    
    public function optionTitle(array $option = [])
    {
        return $option['title'];
    }
    
    public function input()
    {
        
        return "<input {$this->attributes()}/>";
    }
    
    public function select()
    {
        $res = '<select ' . $this->attributes() . '>';
        foreach ($this->object->options() as $option) {
            $optionString = '<option value="' . $option['value'] . '"';
            if ($this->object->optionSelected($option['value'])) {
                $optionString .= ' selected="selected"';
            }
            $optionString .= '>' . $option['title'] . '</option>';
            $res .= $optionString;
        }
        $res .= '</select>';
        
        return $res;
    }
    
    public function textArea()
    {
        return "<textarea {$this->attributes()}>{$this->object->getValue()}</textarea>";
    }
}