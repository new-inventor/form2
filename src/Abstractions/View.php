<?php
/**
 * Date: 04.10.16
 * Time: 13:19
 */

namespace NewInventor\Form\Abstractions;


use NewInventor\Form\HtmlAttributeList;
use NewInventor\Form\Interfaces\Arrayable;
use NewInventor\Form\TypeChecker\TypeCheck;

class View
{
    use TypeCheck;
    protected $attributes;
    protected $title;
    protected $template;
    protected $errors;
    /**
     * @var Arrayable
     */
    protected $object;

    /**
     * View constructor.
     * @param Arrayable $object
     * @param array $attributes
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function __construct($object, array $attributes)
    {
        $this->param(0)->inner()->string()->int()->double()->null()->fail();
        $this->attributes = HtmlAttributeList::make($attributes);
    }

    /**
     * @param string $name
     * @param string|int|double|null $value
     *
     * @return $this
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function attribute($name, $value = '')
    {
        $this->param(1)->string()->int()->double()->null()->fail();
        $this->attributes->set($name, $value);
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $title
     * @return $this
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function setTitle($title)
    {
        $this->param(0)->string()->fail();
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $templateUrl
     * @return $this
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function setTemplate($templateUrl)
    {
        $this->param(0)->string()->callback(function($value){
            return file_exists($value);
        })->fail();
        $this->template = $templateUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return $this
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function setErrors(array $errors)
    {
        $this->param(0)->inner()->string()->fail();
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param $error
     * @return $this
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function addError($error)
    {
        $this->param(0)->string()->fail();
        $this->errors[] = $error;
        return $this;
    }

    public function render()
    {
        $parameters['attributes'] = $this->attributes->all();
        $parameters['attributesString'] = $this->attributes->getString();
        $parameters['title'] = $this->title;
        $parameters['errors'] = $this->errors;
        $parameters = array_merge($parameters, $this->object->toArray());
        extract($parameters, EXTR_OVERWRITE);
        /** @noinspection PhpIncludeInspection */
        include $this->template;
    }
}