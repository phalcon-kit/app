<?php

namespace App\Modules\Api;

class Module extends \PhalconKit\Modules\Api\Module
{
    final public function getNamespaces(): array
    {
        return array_merge([
            'App\\Models' => APP_PATH . '/Models/'
        ], parent::getNamespaces());
    }
}
