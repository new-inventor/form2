<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 19:49
 */

namespace NewInventor\Form\Http\Exceptions;


class HttpMethod extends \Exception
{

    /**
     * HttmMethod constructor.
     *
     * @param string $method
     */
    public function __construct($method)
    {
        parent::__construct("Method '$method' not allowed.");
    }
}