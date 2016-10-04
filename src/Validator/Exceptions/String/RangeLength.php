<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 17:00
 */

namespace NewInventor\Form\Validator\Exceptions\Str;


//use NewInventor\Form\Validator\Exceptions\Str\Traits\MinLengthTrait;
//use NewInventor\Form\Validator\Exceptions\Str\Traits\MaxLengthTrait;

class RangeLength extends Base
{
    //use MinLengthTrait;
    //use MaxLengthTrait;
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minLength
     * @param int $maxLength
     * @param string $message
     */
    public function __construct($objectName, $minLength, $maxLength, $message = '')
    {
//        $this->setMinLength($minLength);
//        $this->setMaxLength($maxLength);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Длина значения поля "{n}" должна быть между {minLength} и {maxLength} символами.';
    }
}