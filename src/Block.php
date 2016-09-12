<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:00
 */

namespace NewInventor\Form;

use DeepCopy\DeepCopy;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Field\CheckBox;
use NewInventor\Form\Field\CheckBoxSet;
use NewInventor\Form\Field\Input;
use NewInventor\Form\Field\RadioSet;
use NewInventor\Form\Field\Select;
use NewInventor\Form\Field\TextArea;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Renderer\BlockRenderer;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

/**
 * Class AbstractBlock
 * @package NewInventor\Form
 */
class Block extends FormObject implements BlockInterface
{
    private $repeatable;
    
    private $repeatObject;
    
    /**
     * AbstractBlock constructor.
     *
     * @param string $name
     * @param string $title
     */
    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
    }
    
    /**
     * @inheritdoc
     */
    public function block($name, $title = '')
    {
        $block = new Block($name, $title);
        $block->setParent($this);
        $this->children()->add($block);
        
        return $block;
    }
    
    /**
     * @inheritdoc
     */
    public function button($name, $value = '')
    {
        return $this->addInputField('button', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function checkbox($name, $value = false)
    {
        $checkbox = new CheckBox($name, $value);
        
        return $this->field($checkbox);
    }
    
    /**
     * @inheritdoc
     */
    public function file($name, $value = '')
    {
        return $this->addInputField('file', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function hidden($name, $value = '')
    {
        return $this->addInputField('hidden', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function image($name, $value = '')
    {
        return $this->addInputField('image', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function password($name, $value = '')
    {
        return $this->addInputField('password', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function radio($name, $value = '')
    {
        return $this->addInputField('radio', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function radioSet($name, $value = '')
    {
        $set = new RadioSet($name, $value);
        $this->field($set);
        
        return $set;
    }
    
    /**
     * @inheritdoc
     */
    public function reset($name, $value = '')
    {
        return $this->addInputField('reset', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function submit($name, $value = '')
    {
        return $this->addInputField('submit', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function text($name, $value = '')
    {
        return $this->addInputField('text', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function color($name, $value = '')
    {
        return $this->addInputField('color', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function date($name, $value = '')
    {
        return $this->addInputField('date', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function datetime($name, $value = '')
    {
        return $this->addInputField('datetime', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function datetimeLocal($name, $value = '')
    {
        return $this->addInputField('datetimeLocal', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function email($name, $value = '')
    {
        return $this->addInputField('email', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function number($name, $value = '')
    {
        return $this->addInputField('number', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function range($name, $value = '')
    {
        return $this->addInputField('range', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function search($name, $value = '')
    {
        return $this->addInputField('search', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function tel($name, $value = '')
    {
        return $this->addInputField('tel', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function time($name, $value = '')
    {
        return $this->addInputField('time', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function url($name, $value = '')
    {
        return $this->addInputField('url', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function month($name, $value = '')
    {
        return $this->addInputField('month', $name, $value);
    }
    
    /**
     * @inheritdoc
     */
    public function week($name, $value = '')
    {
        return $this->addInputField('week', $name, $value);
    }
    
    protected function addInputField($type, $name, $value)
    {
        $field = new Input($name, $value);
        $field->attribute('type', $type);
        
        return $this->field($field);
    }
    
    /**
     * @inheritdoc
     */
    public function select($name, $value = null)
    {
        $select = new Select($name, $value, '');
        
        return $this->field($select);
    }
    
    /**
     * @inheritdoc
     */
    public function textArea($name, $value = '')
    {
        $textArea = new TextArea($name, $value);
        
        return $this->field($textArea);
    }
    
    /**
     * @inheritdoc
     */
    public function checkBoxSet($name, $value = null)
    {
        $checkBoxSet = new CheckBoxSet($name, $value);
        
        return $this->field($checkBoxSet);
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