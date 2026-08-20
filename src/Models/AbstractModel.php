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

namespace App\Models;

/**
 * Application-owned base for generated model abstracts.
 *
 * Add only behavior shared by the complete application model layer here.
 * Table-specific behavior belongs in the concrete model classes so scaffold
 * regeneration can safely replace schema-derived abstract classes.
 */
abstract class AbstractModel extends \PhalconKit\Models\AbstractModel
{
}
