<?php

require __DIR__ . '/vendor/autoload.php';
use \NewInventor\ConfigTool\Config;
use \NewInventor\Form\Form;
use \NewInventor\Form\Field\FieldFactory;
use \NewInventor\Form\Block;
Config::init(__DIR__ . '/config');

FieldFactory::make('input', 'name')->render();
Block::make('block')->checkBox('check', true)->end()->render();
Form::make('form')->render();
