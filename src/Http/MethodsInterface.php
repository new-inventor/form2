<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 23:43
 */

namespace NewInventor\Form\Http;


use NewInventor\Form\Http\Exceptions\HttpMethod;

interface MethodsInterface
{
    /**
     * @param string[] ...$methods
     *
     * @return $this
     */
    public function availableMethods(...$methods);

    /**
     * @return $this
     */
    public function options();

    /**
     * @return $this
     */
    public function get();

    /**
     * @return $this
     */
    public function head();

    /**
     * @return $this
     */
    public function post();

    /**
     * @return $this
     */
    public function put();

    /**
     * @return $this
     */
    public function delete();

    /**
     * @return $this
     */
    public function trace();

    /**
     * @return $this
     */
    public function connect();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param $method
     *
     * @return $this
     * @throws HttpMethod
     */
    public function method($method);
}