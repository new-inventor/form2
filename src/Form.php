<?php

namespace NewInventor\Form;

use NewInventor\Form\Abstraction\KeyValue;
use NewInventor\Form\Field\AbstractField;
use NewInventor\Form\Http\Method;
use NewInventor\Form\Http\Methodable;
use NewInventor\Form\Http\MethodsInterface;
use NewInventor\Form\Interfaces\FormInterface;
use NewInventor\Form\Renderer\FormRenderer;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\TypeChecker\TypeChecker;

//TODO сделать настраиваемое положение ошибок
//TODO AJAX send(by change, by submit)
//TODO user validation (one by one + full form + pre send)
//TODO creation from array
//TODO multi step forms
//TODO from and to object translators
//TODO check security
//TODO fill up the field types(captcha, date picker, file preview, file drop down, rating, code, html, range, geo map, ...)
//TODO some custom patterns
//TODO translate to php 7
//TODO change validators (elements relations) and translate to separate project. Fill up validators
//TODO i18n internationalisation
//TODO Increase work speed
//TODO горячие клавиши для форм
//TODO опциональное шифрование данных формы
//TODO визуальный конструктор
//TODO

class Form extends Block implements FormInterface, MethodsInterface
{
    use Methodable;

    const ENC_TYPE_URLENCODED = 'urlencoded';
    const ENC_TYPE_MULTIPART = 'multipart';
    const ENC_TYPE_PLAIN = 'plain';
    
    const STATUS_NORMAL = 0;
    const STATUS_BEFORE_REDIRECT = 1;
    const STATUS_SHOW_RESULT = 2;
    
    protected static $encTypes = [
        'urlencoded' => 'application/x-www-form-urlencoded',
        'multipart'  => 'multipart/form-data',
        'plain'      => 'text/plain'
    ];

    /** @var string */
    protected $action;
    /** @var string */
    protected $encType;
    
    /**
     * AbstractForm constructor.
     *
     * @param string $name
     * @param string $title
     * @param string $action
     * @param string $method
     * @param string $encType
     *
     * @throws ArgumentException
     * @throws ArgumentTypeException
     */
    public function __construct(
        $name,
        $action = '',
        $method = 'post',
        $title = '',
        $encType = self::ENC_TYPE_URLENCODED
    ) {
        parent::__construct($name, $title);
        $this->availableMethods(Method::GET, Method::POST);
        if (!is_null($action)) {
            $this->action($action);
        }
        $this->children()->setElementClasses([Block::getClass(), AbstractField::getClass()]);
    }
    
    /**
     * @inheritdoc
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @inheritdoc
     */
    public function action($action)
    {
        TypeChecker::getInstance()
            ->isString($action, 'action')
            ->throwTypeErrorIfNotValid();
        $this->action = $action;
        $this->attributes()->add(new KeyValue('action', $action));
        
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getEncType()
    {
        return $this->encType;
    }

    public function urlencoded()
    {
        $this->encType = self::$encTypes['urlencoded'];
        return $this;
    }

    public function multipart()
    {
        $this->encType = self::$encTypes['multipart'];
        return $this;
    }

    public function plain()
    {
        $this->encType = self::$encTypes['plain'];
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $res = parent::toArray();
        $res['method'] = $this->getMethod();
        $res['action'] = $this->getAction();
        $res['encType'] = $this->getEncType();
        
        return $res;
    }
}