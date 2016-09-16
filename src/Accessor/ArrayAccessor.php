<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 14.09.2016
 * Time: 10:21
 */

namespace NewInventor\Form\Accessor;


use NewInventor\Form\TypeChecker\SimpleTypes;
use NewInventor\Form\TypeChecker\TypeChecker;

class ArrayAccessor implements AccessorInterface
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data)
    {
        return new static($data);
    }

    /**
     * @param string|int|array $name
     * @param mixed            $default
     *
     * @return array|mixed
     */
    public function get($name, $default = null)
    {
        $this->checkNameType($name);
        $route = $this->prepareRoute($name);
        $routeStr = $this->getArrayRoute($route);
        return $routeStr === null ? $default : eval("return \$this->data$routeStr;");
    }

    /**
     * @param string|int|array $name
     *
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    protected function checkNameType($name)
    {
        TypeChecker::getInstance()
            ->check($name, [SimpleTypes::STRING, SimpleTypes::INT, SimpleTypes::ARR], 'name')
            ->throwTypeErrorIfNotValid();
    }

    /**
     * @param string|int|array $route
     *
     * @return array
     */
    protected function prepareRoute($route)
    {
        if (is_string($route)) {
            $route = explode('.', $route);
        } elseif (is_int($route)) {
            $route = [$route];
        }
        return $route;
    }

    /**
     * @param array $route
     * @param bool  $full
     *
     * @return array|mixed
     */
    protected function getArrayRoute(array $route, $full = false)
    {
        $el = $this->data;
        $routeStr = '';
        foreach ($route as $part) {
            if (array_key_exists($part, $el)) {
                $routeStr = $this->addPartToRoute($routeStr, $part);
                $el = $el[$part];
            } elseif($full) {
                $routeStr = $this->addPartToRoute($routeStr, $part);
            } else {
                return null;
            }
        }
        return $routeStr;
    }

    protected function addPartToRoute($route, $part)
    {
        return $route . "['$part']";
    }

    /**
     * @param string|int|array $name
     * @param mixed            $value
     *
     * @return $this
     * @throws \NewInventor\Form\Accessor\Exceptions\ElementNotFound
     */
    public function set($name, $value)
    {
        $this->checkNameType($name);
        $route = $this->prepareRoute($name);
        $routeStr = $this->getArrayRoute($route, true);
        eval("\$this->data$routeStr = \$value;");
        return $this;
    }

    /**
     * @param string|int|array $name
     *
     * @return bool
     * @throws \NewInventor\Form\Accessor\Exceptions\ElementNotFound
     */
    public function forget($name)
    {
        $this->checkNameType($name);
        if ($this->has($name)) {
            $route = $this->prepareRoute($name);
            $routeStr = $this->getArrayRoute($route);
            eval("unset(\$this->data$routeStr);");
            return true;
        }
        return false;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        $this->checkNameType($name);
        $route = $this->prepareRoute($name);
        $routeStr = $this->getArrayRoute($route);
        return $routeStr !== null;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @param AccessorInterface[] ...$accessors
     *
     * @return $this
     */
    public function merge(AccessorInterface ...$accessors)
    {
        $array = [];
        foreach($accessors as $accessor){
            $array[] = $accessor->all();
        }
        array_unshift($array, $this->data);
        $this->data = call_user_func_array('array_replace_recursive', $array);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->data = [];
        return $this;
    }

    /**
     * @return AccessorInterface
     */
    public function copy()
    {
        $obj = new \ArrayObject($this->data);
        return new static($obj->getArrayCopy());
    }
}