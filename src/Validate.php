<?php
/**
 * Date: 12.09.16
 * Time: 16:39
 */

namespace NewInventor\Form;


use NewInventor\Abstractions\Interfaces\ObjectListInterface;
use NewInventor\Form\Validator\Interfaces\ValidatorInterface;
use NewInventor\TypeChecker\Exception\ArgumentTypeException;

trait Validate
{
    /** @var \Iterator|ObjectListInterface */
    protected $validators;
    /** @var bool */
    protected $validated = false;

    /**
     * @inheritdoc
     */
    public function validate($revalidate = false)
    {
        if ($this->validated && !$revalidate) {
            return $this->isValid();
        }
        foreach ($this->validators() as $validator) {
            if ($validator->isValid($this->getValue())) {
                continue;
            }
            $this->isValid = false;
            $this->errors[] = $validator->getError();
        }
        return $this->isValid();
    }

    /**
     * @return \Iterator|ObjectListInterface
     */
    public function validators()
    {
        return $this->validators;
    }

    /**
     * @param $name
     * @return ValidatorInterface|null
     * @throws ArgumentTypeException
     */
    public function getValidator($name)
    {
        return $this->validators()->get($name);
    }
}