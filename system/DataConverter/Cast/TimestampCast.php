<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\DataConverter\Cast;

use CodeIgniter\I18n\Time;

/**
 * Class TimestampCast
 *
 * (PHP) [Time --> int       ] --> (DB driver) --> (DB column) int
 *       [     <-- int|string] <-- (DB driver) <-- (DB column) int
 *
 * @extends BaseCast<Time, int, mixed>
 */
class TimestampCast extends BaseCast
{
    public static function fromDataSource(mixed $value, array $params = []): Time
    {
        if (! is_int($value) && ! is_string($value)) {
            self::invalidTypeValueError($value);
        }

        return Time::createFromTimestamp((int) $value);
    }

    public static function toDataSource(mixed $value, array $params = []): int
    {
        if (! $value instanceof Time) {
            self::invalidTypeValueError($value);
        }

        return $value->getTimestamp();
    }
}
