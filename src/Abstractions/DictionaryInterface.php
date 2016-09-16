<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 17.09.2016
 * Time: 1:42
 */
namespace NewInventor\Form\Abstractions;

interface DictionaryInterface
{
    /**
     * @param array $data
     *
     * @return static
     */
    public static function make(array $data = []);

    /**
     * @param string|int $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null);

    /**
     * @param mixed $value
     * @param bool  $strict
     *
     * @return mixed
     */
    public function find($value, $strict = false);

    /**
     * @param string|int $name
     *
     * @return bool
     */
    public function exists($name);

    /**
     * @param string|int $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function set($name, $value);

    /**
     * @return $this
     */
    public function clear();

    /**
     * @param string[] ...$name
     *
     * @return $this
     */
    public function remove(...$name);

    /**
     * @return array
     */
    public function all();

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current();

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next();

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key();

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid();

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind();
}