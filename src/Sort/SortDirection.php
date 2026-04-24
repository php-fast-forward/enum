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

enum SortDirection implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case Ascending;
    case Descending;

    public function reverse(): static
    {
        return match ($this) {
            self::Ascending => self::Descending,
            self::Descending => self::Ascending,
        };
    }

    public function isAscending(): bool
    {
        return $this->is(self::Ascending);
    }

    public function isDescending(): bool
    {
        return $this->is(self::Descending);
    }

    public function factor(): int
    {
        return match ($this) {
            self::Ascending => 1,
            self::Descending => -1,
        };
    }

    public function applyToComparisonResult(int $result): int
    {
        return $result * $this->factor();
    }
}
