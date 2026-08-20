<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use App\Config\Config;

/**
 * Application bootstrap that supplies the project-owned configuration.
 */
class Bootstrap extends \PhalconKit\Bootstrap
{
    /**
     * Register the application configuration before Core services boot.
     */
    final public function initialize(): void
    {
        $this->setConfig(new Config());
    }
}
