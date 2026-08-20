<?php

declare(strict_types=1);

namespace App\Config;

use PhalconKit\Bootstrap\Config as BaseConfig;
use PhalconKit\Cli\Module as CliModule;
use PhalconKit\Locale;
use PhalconKit\Mvc\Module as MvcModule;
use PhalconKit\Support\Env;

/**
 * Project-owned configuration layered over PhalconKit's defaults.
 *
 * Keep modules, providers, model aliases, and ACL policy here. Put
 * environment-specific values in `.env`, never directly in this class.
 */
class Config extends BaseConfig
{
    /**
     * Merge project defaults with caller-provided overrides.
     *
     * @param array<string, mixed> $data Application-specific overrides.
     * @param bool $insensitive Whether configuration keys are case-insensitive.
     */
    public function __construct(array $data = [], bool $insensitive = false)
    {
        $this->defineConst();
        $data = $this->internalMergeAppend([
            
            'app' => [
                'name' => Env::get('APP_NAME', 'Phalcon Kit App'),
                'namespace' => 'App',
                'version' => Env::get('APP_VERSION', '1.0.0'),
            ],
            
            'modules' => [
                MvcModule::NAME_API => [
                    'className' => \App\Modules\Api\Module::class,
                    'path' => APP_PATH . 'Modules/Api/Module.php',
                ],
                MvcModule::NAME_ADMIN => [
                    'className' => \App\Modules\Admin\Module::class,
                    'path' => APP_PATH . 'Modules/Admin/Module.php',
                ],
                MvcModule::NAME_FRONTEND => [
                    'className' => \App\Modules\Frontend\Module::class,
                    'path' => APP_PATH . 'Modules/Frontend/Module.php',
                ],
                CliModule::NAME_CLI => [
                    'className' => \App\Modules\Cli\Module::class,
                    'path' => APP_PATH . 'Modules/Cli/Module.php',
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
                // Add project-specific service providers here.
            ],
            
            'models' => [
                // Override PhalconKit model aliases with project models here.
            ],
            
            'permissions' => [
                'roles' => [
                    'everyone' => [
                        'components' => [
                            \App\Modules\Frontend\Controllers\IndexController::class => ['index'],
                            \App\Modules\Admin\Controllers\IndexController::class => ['index'],
                            \App\Modules\Api\Controllers\IndexController::class => ['index'],
                        ],
                    ],
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
