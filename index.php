<?php

require __DIR__ . '/vendor/autoload.php';
use \NewInventor\ConfigTool\Config;
use \NewInventor\Form\Form;
session_start();
Config::init(__DIR__ . '/config');

\NewInventor\Form\Field\FieldFactory::make()->get('input', 'name')->render();
Form::make('form')->render();