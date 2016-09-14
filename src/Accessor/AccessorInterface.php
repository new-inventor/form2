<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 14.09.2016
 * Time: 10:21
 */

namespace NewInventor\Form\Accessor;


interface AccessorInterface
{
    /**
     * @param $name
     * @param $default
     *
     * @return mixed
     */
    public function get($name, $default);

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value);

    /**
     * @param $name
     */
    public function forget($name);

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * @return array
     */
    public function all();

    /**
     * @param AccessorInterface[] ...$accessors
     */
    public function merge(AccessorInterface ...$accessors);

    public function clear();

    /**
     * @return $this
     */
    public function copy();
}