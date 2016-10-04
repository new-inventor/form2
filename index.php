<?php

require __DIR__ . '/vendor/autoload.php';
use \NewInventor\Form\ConfigTool\Config;
use \NewInventor\Form\Form;
use \NewInventor\Form\Field\FieldFactory;
use \NewInventor\Form\Block;


Config::init(__DIR__ . '/config');
//$attrs = \NewInventor\Form\HtmlAttributeList::make(['asd' => 'fdfsdf', 'sdfsdf'=> 45345, 'dfsdfsdf']);
//$attrs->set('name', 'sddfsdfsdfsdf');
//$attrs->remove($attrs->find(45345));
//$attrs->render();

$tree = new \NewInventor\Form\Abstractions\Tree(null, '54345');
$tree->children()->set('data',  new \NewInventor\Form\Abstractions\Tree($tree, 123));


$field = new \NewInventor\Form\Field\Input('text', '123');
var_dump($field);

$view = new \NewInventor\Form\Abstractions\View($field, ['asd' => 'asd', '123' => 'sdsda']);
$view->setTemplate(__DIR__ . '/src/Views/Input.php');
$view->render();


//FieldFactory::make('input', 'name')->render();
//Block::make('block')->checkBox('check', true)->title('dfsdfsdf')->end()->render();
//Form::make('form')->render();
