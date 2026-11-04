<?php

declare(strict_types=1);

namespace App\Modules\Cli\Tasks;

/**
 * List the application's commands in `./bin/phalcon-kit cli help`.
 *
 * `cli help <task>` forwards to `<task> help` for any task in this namespace,
 * so add a usage line here when you add a task. The cli role grants this task
 * every action; each target task also needs its own `help` grant.
 */
class HelpTask extends \PhalconKit\Modules\Cli\Tasks\HelpTask
{
    public string $cliDoc = <<<DOC
Usage:
  phalcon-kit cli help cron
  phalcon-kit cli help scaffold
  phalcon-kit cli help user

DOC;
}
