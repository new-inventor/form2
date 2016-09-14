<?php
/**
 * Date: 12.09.16
 * Time: 19:04
 */

namespace NewInventor\Form\Interfaces;


interface FactoryInterface
{
    public static function make($object, ...$params);
}