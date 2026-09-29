<?php

declare(strict_types=1);

namespace App\Modules\Cli\Tasks;

/**
 * Expose Core's account commands through the application CLI namespace.
 *
 * The cli permission grants account maintenance only to console execution.
 * Core's user task resolves application model mappings and model permissions.
 */
class UserTask extends \PhalconKit\Modules\Cli\Tasks\UserTask
{
}
