<?php
/**
 * Date: 03.10.16
 * Time: 17:19
 */

namespace NewInventor\Form\Exceptions;


class StringableException extends \Exception
{
    const MESSAGE = 0;
    const FILE = 1;
    const LINE = 2;
    const BASK_TRACE = 4;
    const CODE = 8;
    const PREVIOUS = 16;
    const FULL = self::MESSAGE | self::FILE | self::LINE | self::BASK_TRACE | self::CODE | self::PREVIOUS;

    public function getString($flags = 0)
    {
        $res = "Ошибка: {$this->getMessage()}.\n";
        if($flags & self::FILE){
            $res .= "Файл: {$this->getFile()}.\n";
        }
        if($flags & self::LINE){
            $res .= "Строка: {$this->getLine()}.\n";
        }
        if($flags & self::CODE){
            $res .= "Строка: {$this->getCode()}.\n";
        }
        if($flags & self::PREVIOUS){
            $res .= "Строка: {$this->getPrevious()}.\n";
        }
        if($flags & self::BASK_TRACE){
            $res .= "Стек вызовов: {$this->getTraceAsString()}.\n";
        }

        return $res;
    }
}