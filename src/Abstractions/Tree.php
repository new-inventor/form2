<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 17.09.2016
 * Time: 1:23
 */

namespace NewInventor\Form\Abstractions;


class Tree
{
    protected $children;
    protected $parent;
    protected $data;

    /**
     * Tree constructor.
     *
     * @param Tree $parent
     * @param null $value
     */
    public function __construct(Tree $parent = null, $value = null)
    {
        $this->children = new Dictionary();
        $this->parent = $parent;
        $this->value = $value;
    }

    public function children()
    {
        return $this->children;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function value()
    {
        return $this->value;
    }
}