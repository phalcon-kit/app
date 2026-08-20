<?php

declare(strict_types=1);

use App\Config;
use PhalconKit\Bootstrap\Devtools;

require_once __DIR__ . '/bootstrap.php';

$config = new Config();

return new Devtools($config->toArray());
