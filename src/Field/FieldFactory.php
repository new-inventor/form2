<?php
/**
 * Date: 12.09.16
 * Time: 18:20
 */

namespace NewInventor\Form\Field;


use NewInventor\Form\Abstraction\BaseFactory;
use NewInventor\Form\Interfaces\FieldInterface;

/**
 * Class FieldFactory
 * @package NewInventor\Form\Field
 * @method FieldInterface static make($object, ...$params)
 */
class FieldFactory extends BaseFactory
{
    protected $name = 'field';
}