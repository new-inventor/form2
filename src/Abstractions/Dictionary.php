<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 16.09.2016
 * Time: 22:13
 */

namespace NewInventor\Form\Abstractions;


use NewInventor\Form\TypeChecker\TypeCheck;

class Dictionary implements \Iterator, DictionaryInterface
{
    use TypeCheck;
    protected $data = [];

    /**
     * Dictionary constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function make(array $data = [])
    {
        return new static($data);
    }

    /**
     * @param string|int $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        return $this->exists($name) ? $this->data[$name] : $default;
    }

    /**
     * @param mixed $value
     * @param bool $strict
     *
     * @return mixed
     */
    public function find($value, $strict = false)
    {
        return array_search($value, $this->data, $strict);
    }

    /**
     * @param string|int $name
     *
     * @return bool
     */
    public function exists($name)
    {
        $this->param()->string()->int()->fail();
        return array_key_exists($name, $this->data);
    }

    /**
     * @param string|int $name
     * @param mixed $value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->param(0)->string()->int()->fail();
        $this->data[$name] = $value;
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
     * @param string[] ...$name
     *
     * @return $this
     */
    public function remove(...$name)
    {
        foreach ($name as $item) {
            if ($this->exists($item)) {
                unset($this->data[$item]);
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        $key = key($this->data);
        return ($key !== null && $key !== false);
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->data);
    }
}