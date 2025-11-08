<?php

use PhalconKit\Bootstrap\Devtools;
use App\Config\Config;

$loader = require 'loader.php';

$config = new Config();
return new Devtools($config->toArray());
