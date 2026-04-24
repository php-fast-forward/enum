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

namespace FastForward\Enum\Sort;

use FastForward\Enum\ReversibleInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;

enum NullsPosition implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case First;
    case Last;

    public function reverse(): static
    {
        return match ($this) {
            self::First => self::Last,
            self::Last => self::First,
        };
    }

    public function isFirst(): bool
    {
        return $this->is(self::First);
    }

    public function isLast(): bool
    {
        return $this->is(self::Last);
    }

    public function compareNullability(mixed $left, mixed $right): int
    {
        if (null === $left && null === $right) {
            return 0;
        }

        if (null === $left) {
            return $this->isFirst() ? -1 : 1;
        }

        if (null === $right) {
            return $this->isFirst() ? 1 : -1;
        }

        return 0;
    }
}
