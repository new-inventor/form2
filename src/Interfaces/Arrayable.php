<?php
/**
 * Date: 04.10.16
 * Time: 16:08
 */

namespace NewInventor\Form\Interfaces;


interface Arrayable
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data);
}