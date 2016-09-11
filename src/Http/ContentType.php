<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 18:56
 */

namespace NewInventor\Form\Http;


use NewInventor\Form\Http\Exceptions\Type;

class ContentType
{
    protected static $acceptedTypes = ['text', 'application', 'multipart', 'message', 'audio', 'video', 'image'];
    protected $type = 'text';
    protected $subtype = 'plain';
    protected $parameters = [];

    /**
     * ContentType constructor.
     *
     * @param       $type
     * @param       $subtype
     * @param array ...$parameters
     *
     * @throws \Exception
     */
    public function __construct($type, $subtype, ...$parameters)
    {
        $this->setType($type);
        $this->subtype = $subtype;
        $this->parameters = $parameters;
    }

    protected function setType($type)
    {
        if($this->checkType($type)){
            $this->type = $type;
        } else {
            throw new Type($type);
        }
    }

    public function checkType($type)
    {
        return in_array($type, self::$acceptedTypes, true) || stripos($type, 'x-') === 0;
    }

    public function __toString()
    {
        return $this->type . '/' . $this->subtype .  (count($this->parameters) === 0 ? '' : '; ' . implode('; ', $this->parameters));
    }
}