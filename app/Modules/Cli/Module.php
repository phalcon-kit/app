<?php

namespace App\Modules\Cli;

class Module extends \PhalconKit\Modules\Cli\Module
{
    final public function getNamespaces(): array
    {
        return array_merge([
            'App\\Models' => APP_PATH . '/Models/',
        ], parent::getNamespaces());
    }
}
