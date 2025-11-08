<?php

namespace App\Modules\Frontend;

class Module extends \PhalconKit\Modules\Frontend\Module
{
    final public function getNamespaces(): array
    {
        return array_merge([
            'App\\Models' => APP_PATH . '/Models/'
        ], parent::getNamespaces());
    }
}
