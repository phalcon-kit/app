<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;

defined('ROOT_PATH') || define('ROOT_PATH', __DIR__ . '/');
defined('APP_PATH') || define('APP_PATH', ROOT_PATH . 'src/');
defined('PUBLIC_PATH') || define('PUBLIC_PATH', ROOT_PATH . 'public/');
defined('RESOURCES_PATH') || define('RESOURCES_PATH', ROOT_PATH . 'resources/');
defined('STORAGE_PATH') || define('STORAGE_PATH', ROOT_PATH . 'storage/');
defined('VENDOR_PATH') || define('VENDOR_PATH', ROOT_PATH . 'vendor/');

$autoloadPath = VENDOR_PATH . 'autoload.php';

if (!is_file($autoloadPath)) {
    throw new RuntimeException('Composer dependencies are missing. Run `composer install` first.');
}

/** @var ClassLoader $loader */
$loader = require $autoloadPath;

return $loader;
