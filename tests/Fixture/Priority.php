<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/enum.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/enum
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForward\Enum\Tests\Fixture;

use FastForward\Enum\LabeledEnumInterface;

enum Priority: int implements LabeledEnumInterface
{
    case Low = 1;
    case High = 2;

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low priority',
            self::High => 'High priority',
        };
    }
}
