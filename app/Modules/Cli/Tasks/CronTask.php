<?php

namespace App\Modules\Cli\Tasks;

use PhalconKit\Support\Utils;

class CronTask extends AbstractTask
{
    final public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
    }
    
    final public function runAction(): array
    {
        $response = [];
        
        // add your cron actions here
        
        return $response;
    }
}
