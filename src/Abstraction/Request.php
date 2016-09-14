<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 14.09.2016
 * Time: 10:13
 */

namespace NewInventor\Form\Abstraction;


use NewInventor\Form\Accessor\ArrayAccessor;

class Request extends ArrayAccessor
{
    /**
     * Request constructor.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct(array_replace_recursive($_POST, $_GET, $_FILES, $_REQUEST, $_SESSION));
    }
}