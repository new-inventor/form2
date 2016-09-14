<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 14.09.2016
 * Time: 19:17
 */

namespace NewInventor\Form\Accessor\Exceptions;


class ElementNotFound extends \Exception
{

    /**
     * ElementNotFound constructor.
     *
     * @param string     $elementName
     * @param int        $code
     * @param \Exception $previous
     *
     * @internal param \Exception $exception
     */
    public function __construct($elementName = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct("Element '$elementName' not found.", $code, $exception);
    }
}