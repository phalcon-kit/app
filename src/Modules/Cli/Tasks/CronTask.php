<?php

declare(strict_types=1);

namespace App\Modules\Cli\Tasks;

use PhalconKit\Support\Utils;

class CronTask extends AbstractTask
{
    final public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
    }

    /** @return array<string, mixed> */
    final public function runAction(): array
    {
        $response = [];

        // Add scheduled application work here.

        return $response;
    }
}
