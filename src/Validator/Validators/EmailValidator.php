<?php
/**
 * User: Ionov George
 * Date: 18.02.2016
 * Time: 16:59
 */

namespace NewInventor\Form\Validator\Validators;

use NewInventor\Form\Validator\AbstractValidator;
use NewInventor\Form\Validator\Exceptions\Email\NotValid;

class EmailValidator extends AbstractValidator
{
    public function validateValue($value)
    {
        if (mb_strlen($value) === 0) {
            return true;
        }
        if(filter_var($value, FILTER_VALIDATE_EMAIL) === $value){
            return true;
        }
        throw new NotValid($this->objectName, $this->message);
    }
}