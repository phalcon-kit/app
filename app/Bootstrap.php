<?php
/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace App;

use App\Config\Config;

class Bootstrap extends \PhalconKit\Bootstrap
{
    final public function initialize(): void
    {
        $this->setConfig(new Config());
    }
}
