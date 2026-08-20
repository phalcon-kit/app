<?php

declare(strict_types=1);

namespace App\Modules\Cli;

use PhalconKit\Modules\Cli\Module as BaseModule;

/**
 * Registers project namespaces for CLI tasks.
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
