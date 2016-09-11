<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 20:14
 */

namespace NewInventor\Form\Http\Exceptions;


class Type extends \Exception
{
    /**
     * HttmMethod constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        parent::__construct("Bad type '$type'.");
    }
}