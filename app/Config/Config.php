<?php

namespace App\Config;

use PhalconKit\Cli\Module as CliModule;
use PhalconKit\Locale;
use PhalconKit\Mvc\Module as MvcModule;
use PhalconKit\Support\Env;

class Config extends \PhalconKit\Bootstrap\Config
{
    public function __construct(array $data = [], bool $insensitive = false)
    {
        $this->defineConst();
        $data = $this->internalMergeAppend([
            
            'app' => [
                'version' => '1.0.0'
            ],
            
            'modules' => [
                MvcModule::NAME_API => [
                    'className' => \App\Modules\Api\Module::class,
                    'path' => APP_PATH . '/Modules/Api/Module.php',
                ],
                MvcModule::NAME_ADMIN => [
                    'className' => \App\Modules\Admin\Module::class,
                    'path' => APP_PATH . '/Modules/Admin/Module.php',
                ],
                MvcModule::NAME_FRONTEND => [
                    'className' => \App\Modules\Frontend\Module::class,
                    'path' => APP_PATH . '/Modules/Frontend/Module.php',
                ],
                CliModule::NAME_CLI => [
                    'className' => \App\Modules\Cli\Module::class,
                    'path' => APP_PATH . '/Modules/Cli/Module.php',
                ],
            ],
            
            'router' => [
                'defaults' => [
                    'namespace' => Env::get('ROUTER_DEFAULT_NAMESPACE', 'App\\Modules\\Frontend\\Controllers'),
                    'module' => Env::get('ROUTER_DEFAULT_MODULE', MvcModule::NAME_FRONTEND),
                ],
            ],
            
            'locale' => [
                'default' => Env::get('LOCALE_DEFAULT', 'en'),
                'mode' => Env::get('LOCALE_MODE', Locale::MODE_DEFAULT),
                'allowed' => explode(',', Env::get('LOCALE_ALLOWED', 'en')),
            ],
            
            'providers' => [
                // add your providers here
            ],
            
            'models' => [
                // override native phalcon kit models with your own
            ],
            
            'permissions' => [
                // add your application acl permissions here
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
