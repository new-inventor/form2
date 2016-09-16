<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 16.09.2016
 * Time: 23:29
 */

namespace NewInventor\Form\TypeChecker;


use NewInventor\Form\TypeChecker\Exception\ArgumentTypeException;

/**
 * Class TypeChecker
 * @package NewInventor\Form\TypeChecker
 * @method TypeChecker bool()
 * @method TypeChecker string()
 * @method TypeChecker int()
 * @method TypeChecker double()
 * @method TypeChecker array()
 * @method TypeChecker object()
 * @method TypeChecker resource()
 * @method TypeChecker null()
 */
class TypeChecker
{
    protected $file;
    protected $line;
    protected $class;
    protected $function;
    protected $type;

    protected $value;
    protected $index;
    
    protected $isValid = false;
    protected $inner = false;

    protected $types = [];
    protected $innerTypes = [];

    /**
     * NewTypeChecker constructor.
     *
     * @param array $backTraceData
     * @param int   $paramIndex
     */
    public function __construct(array $backTraceData, $paramIndex)
    {
        $this->line = $backTraceData['line'];
        $this->file = $backTraceData['file'];
        $this->class = $backTraceData['class'];
        $this->function = $backTraceData['function'];
        $this->type = $backTraceData['type'];
        $this->index = $paramIndex;
        $this->value = $backTraceData['args'][$paramIndex];
    }

    public function __call($name, array $arguments)
    {
        if($this->inner){
            return $this->checkSimpleArray($name);
        }
        return $this->checkSimple($name);
    }

    protected function checkSimple($name)
    {
        $method = "is_$name";
        $this->types[] = $name;
        $this->isValid = $this->isValid || $method($this->value);
        return $this;
    }

    protected function checkSimpleArray($name)
    {
        $method = "is_$name";
        $this->innerTypes[] = $name;
        $res = true;
        foreach($this->value as $item){
            $res = $res && $method($item);
        }
        $this->isValid = $this->isValid || $res;
        return $this;
    }

    /**
     * @return $this
     */
    public function inner()
    {
        $this->inner = true;
        return $this;
    }

    /**
     * @param string[] ...$types
     *
     * @return $this
     */
    public function types(...$types)
    {
        if (count($types) === 0) {
            $this->isValid = $this->isValid && true;
            return $this;
        }

        if($this->inner){
            $res = true;
            $this->innerTypes = array_merge($this->innerTypes, $types);
            foreach($this->value as $item){
                $res = $res && $this->checkValueTypes($item, $types);
            }
            $this->isValid = $this->isValid || $res;
        }else {
            $this->types = array_merge($this->types, $types);
            $this->isValid = $this->isValid || $this->checkValueTypes($this->value, $types);
        }

        return $this;
    }

    protected function checkValueTypes($value, array $types)
    {
        $res = false;
        foreach ($types as $type) {
            $res = $res || is_a($value, $type);
        }
        
        return $res;
    }

    /**
     * @throws ArgumentTypeException
     */
    public function fail()
    {
        if(!$this->isValid){
            throw new ArgumentTypeException($this);
        }
    }

    /**
     * @return bool
     */
    public function result()
    {
        return $this->isValid;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return string
     */
    protected function getFullFunctionName()
    {
        return "{$this->class}{$this->type}{$this->function}";
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        $typesStr = implode(', ', $this->types);
        $innerTypesStr = implode(', ', $this->innerTypes);
        $str = "Тип аргумента №{$this->index} в методе {$this->getFullFunctionName()} неверен. ";
        if ($typesStr !== '') {
            $str .= "Необходимые типы параметра: {$typesStr}. ";
        }
        if ($innerTypesStr !== '') {
            $str .= "Необходимые типы элементов параметра: {$innerTypesStr}. ";
        }
        $str .= 'Получен тип: ' . gettype($this->value) . '.';

        return $str;
    }
}