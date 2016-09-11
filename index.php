<?php

require __DIR__ . '/vendor/autoload.php';
use \NewInventor\ConfigTool\Config;
session_start();
Config::init(__DIR__ . '/config');