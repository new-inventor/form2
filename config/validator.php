<?php
return [
    'email' => \NewInventor\Form\Validator\Validators\EmailValidator::getClass(),
    'integer' => \NewInventor\Form\Validator\Validators\IntegerValidator::getClass(),
    'string' => \NewInventor\Form\Validator\Validators\StringValidator::getClass(),
    'required' => \NewInventor\Form\Validator\Validators\RequiredValidator::getClass(),
];