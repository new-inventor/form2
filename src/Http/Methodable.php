<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 18:57
 */

namespace NewInventor\Form\Http;


use NewInventor\Form\Http\Exceptions\HttpMethod;

trait Methodable
{
    protected $availableMethods = [];
    protected $method;

    /**
     * @param string[] ...$methods
     *
     * @return $this
     */
    public function availableMethods(...$methods)
    {
        $this->availableMethods = [];
        foreach($methods as $method){
            if(in_array($method, Method::$methods, true)){
                $this->availableMethods[] = $method;
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function options()
    {
        return $this->method(Method::OPTIONS);
    }

    /**
     * @return $this
     */
    public function get()
    {
        return $this->method(Method::GET);
    }

    /**
     * @return $this
     */
    public function head()
    {
        return $this->method(Method::HEAD);
    }

    /**
     * @return $this
     */
    public function post()
    {
        return $this->method(Method::POST);
    }

    /**
     * @return $this
     */
    public function put()
    {
        return $this->method(Method::PUT);
    }

    /**
     * @return $this
     */
    public function delete()
    {
        return $this->method(Method::DELETE);
    }

    /**
     * @return $this
     */
    public function trace()
    {
        return $this->method(Method::TRACE);
    }

    /**
     * @return $this
     */
    public function connect()
    {
        return $this->method(Method::CONNECT);
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $method
     *
     * @return $this
     * @throws HttpMethod
     */
    public function method($method)
    {
        if (in_array($method, $this->availableMethods, true)) {
            $this->method = $method;
            return $this;
        }

        throw new HttpMethod($method);
    }
}