<?php
/**
 * User: Ionov George
 * Date: 25.04.2016
 * Time: 13:56
 */

namespace NewInventor\Form\Validator\Exceptions\Integer;


use NewInventor\Form\Validator\Exceptions\Base;
use NewInventor\Form\Validator\Exceptions\Integer\Traits\MinTrait;

class Min extends Base
{
    use MinTrait;
    
    /**
     * Base constructor.
     * @param string $objectName
     * @param int $minValue
     * @param string $message
     */
    public function __construct($objectName, $minValue, $message = '')
    {
        $this->setMin($minValue);
        parent::__construct($objectName, $message);
    }
    
    protected function getDefaultMessage()
    {
        return 'Значение поля "{n}" должно быть больше {min}.';
    }
}