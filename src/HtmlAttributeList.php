<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 17.09.2016
 * Time: 0:48
 */

namespace NewInventor\Form;


use NewInventor\Form\Abstractions\Dictionary;

class HtmlAttributeList extends Dictionary
{
    use RenderTrait;

    /**
     * @inheritdoc
     */
    public function getString()
    {
        $attrStrings = [];
        foreach($this->data as $name => $value){
            if(is_int($name)){
                $attrStrings[] = $value;
            }elseif(empty($value)){
                $attrStrings[] = $name;
            }else {
                $attrStrings[] = "$name=\"$value\"";
            }
        }
        return implode(' ', $attrStrings);
    }
}