<?php

declare(strict_types=1);

namespace App\Modules\Cli\Tasks;

/**
 * Expose Core's schema scaffolder through the application CLI namespace.
 *
 * Used by scripts/generate-models and scripts/regenerate-models. The cli role
 * grants this task access; schema inspection uses the configured db service.
 */
class ScaffoldTask extends \PhalconKit\Modules\Cli\Tasks\ScaffoldTask
{
}
