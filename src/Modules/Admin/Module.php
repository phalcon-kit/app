<?php

declare(strict_types=1);

namespace App\Modules\Admin;

use PhalconKit\Modules\Admin\Module as BaseModule;

/**
 * Registers project namespaces for the Admin module.
 */
class Module extends BaseModule
{
    /** @return array<string, string> */
    #[\Override]
    final public function getNamespaces(): array
    {
        return array_merge([
            'App\\Models' => APP_PATH . 'Models/',
        ], parent::getNamespaces());
    }
}
