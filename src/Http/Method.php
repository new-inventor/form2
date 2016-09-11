<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 18:56
 */

namespace NewInventor\Form\Http;


class Method
{
    public static $methods = ['options', 'get', 'head', 'post', 'put', 'delete', 'trace', 'connect'];
    const OPTIONS = 'options';
    const GET = 'get';
    const HEAD = 'head';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    const TRACE = 'trace';
    const CONNECT = 'connect';
}