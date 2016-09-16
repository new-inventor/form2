<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\Form;

use DeepCopy\DeepCopy;
use NewInventor\Form\ConfigTool\Config;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Field\Input;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\TypeChecker\SimpleTypes;
use NewInventor\Form\TypeChecker\TypeChecker;

/**
 * Class AbstractBlock
 * @package NewInventor\Form
 * @method FieldInterface button($name, $value = '')
 * @method FieldInterface checkBox($name, $value = false)
 * @method FieldInterface file($name, $value = '')
 * @method FieldInterface hidden($name, $value = '')
 * @method FieldInterface image($name, $value = '')
 * @method FieldInterface password($name, $value = '')
 * @method FieldInterface radio($name, $value = '')
 * @method FieldInterface radioSet($name, $value = '', $options = null)
 * @method FieldInterface reset($name, $value = '')
 * @method FieldInterface submit($name, $value = '')
 * @method FieldInterface text($name, $value = '')
 * @method FieldInterface color($name, $value = '')
 * @method FieldInterface date($name, $value = '')
 * @method FieldInterface datetime($name, $value = '')
 * @method FieldInterface datetimeLocal($name, $value = '')
 * @method FieldInterface email($name, $value = '')
 * @method FieldInterface number($name, $value = '')
 * @method FieldInterface range($name, $value = '')
 * @method FieldInterface search($name, $value = '')
 * @method FieldInterface tel($name, $value = '')
 * @method FieldInterface time($name, $value = '')
 * @method FieldInterface url($name, $value = '')
 * @method FieldInterface month($name, $value = '')
 * @method FieldInterface week($name, $value = '')
 * @method FieldInterface select($name, $value = '', $options = [])
 * @method FieldInterface textArea($name, $value = '')
 * @method FieldInterface checkBoxSet($name, $value = '', $options = [])
 */
class Block extends FormObject implements BlockInterface
{
    private $repeatable;
    private $repeatObject;
    
    /**
     * @inheritdoc
     */
    public function block($name)
    {
        $block = new Block($name);
        $block->setParent($this);
        $this->children()->add($block);
        
        return $block;
    }

    /**
     * @param $name
     * @param $params
     *
     * @return FieldInterface
     * @throws \BadMethodCallException
     */
    public function __call($name, $params)
    {
        if(Config::exist(['field', $name])){
            $reflector = new \ReflectionClass(Config::get(['field', $name]));
            /** @var FieldInterface $field */
            $field = $reflector->newInstanceArgs($params);
        }else{
            $reflector = new \ReflectionClass(Input::class);
            $field = $reflector->newInstanceArgs($params);
            $field->attribute('type', strtolower($name));
        }
        return $this->field($field);
    }
    
    /**
     * @inheritdoc
     */
    public function field($field)
    {
        $field->setParent($this);
        $this->children()->add($field);
        
        return $field;
    }
    
    /**
     * @inheritdoc
     */
    public function repeatable($object)
    {
        TypeChecker::getInstance()
            ->check($object, [Block::getClass(), AbstractField::getClass()], 'object')
            ->throwTypeErrorIfNotValid();
        
        $repeatableBlockName = $object->getName();
        $repeatableBlockTitle = $object->getTitle();
        $object->title('');
        $repeatableBlock = new Block($repeatableBlockName, $repeatableBlockTitle);
        $repeatableBlock->setRepeatable(true);
        $object->setName('#IND#');
        $repeatableBlock->setRepeatObject($object);
        
        $deepCopy = new DeepCopy();
        $objectClone = $deepCopy->copy($repeatableBlock->getRepeatObject());
        $objectClone->setParent($repeatableBlock);
        $objectClone->setName('0');
        $repeatableBlock->children()->add($objectClone);
        
        $repeatableBlock->setParent($this);
        $this->children()->add($repeatableBlock);
        
        return $this;
    }
    
    //TODO сделать ограничение количества повторяемых блоков
    /**
     * @inheritdoc
     */
    public function load($data = null)
    {
        TypeChecker::getInstance()
            ->check($data, [SimpleTypes::ARR, SimpleTypes::NULL], 'data')
            ->throwTypeErrorIfNotValid();
        if ($data === null) {
            if(isset($_REQUEST[$this->getName()])){
                $data = $_REQUEST[$this->getName()];
            }else {
                return false;
            }
        }
        
        $deepCopy = new DeepCopy();
        foreach ($data as $name => $value) {
            $child = $this->child($name);
            if ($child instanceof FieldInterface) {
                $child->setValue($value);
            } elseif ($child instanceof BlockInterface) {
                if(!$child->isRepeatableContainer()){
                    $child->load($value);
                    continue;
                }
                $value = array_values($value);
                $childrenCount = count($child->children());
                $childrenMaxIndex = $childrenCount - 1;
                $childrenDelta = count($value) - $childrenCount;
                if ($childrenDelta > 0) {
                    for ($i = 0; $i <= $childrenDelta; $i++) {
                        /** @var BlockInterface $objectClone */
                        $objectClone = $deepCopy->copy($child->getRepeatObject());
                        $objectValue = $objectClone->getValue();
                        if ($value[$i] == $objectValue) {
                            $childrenDelta--;
                            array_splice($value, $i, 1);
                            $i--;
                            continue;
                        }
                        $objectClone->setParent($child);
                        $objectClone->setName((string)($childrenCount + $i));
                        $child->children()->add($objectClone);
                    }
                } elseif ($childrenDelta < 0) {
                    $delta = abs($childrenDelta);
                    for ($i = 0; $i < $delta; $i++) {
                        $child->children()->delete(($childrenMaxIndex - $i));
                    }
                } elseif ($childrenDelta == 0 && count($value) == 1 && !empty($value[0])) {
                    $objectClone = $deepCopy->copy($child->getRepeatObject());
                    $objectClone->setParent($child);
                    $objectClone->setName((string)(count($child->children())));
                    $child->children()->add($objectClone);
                }
                $child->load($value);
            }
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function getValue()
    {
        $value = [];
        foreach ($this->children() as $child) {
            $value[$child->getName()] = $child->getValue();
        }
        
        return $value;
    }
    
    /**
     * @inheritdoc
     */
    public function isRepeatableContainer()
    {
        return $this->repeatable;
    }
    
    /**
     * @inheritdoc
     */
    public function setRepeatable($repeatable)
    {
        $this->repeatable = $repeatable;
        
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function clear()
    {
        foreach ($this->children() as $child) {
            $child->clear();
        }
        
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getRepeatObject()
    {
        return $this->repeatObject;
    }
    
    /**
     * @inheritdoc
     */
    public function setRepeatObject($repeatObject)
    {
        $this->repeatObject = $repeatObject;
    }
}