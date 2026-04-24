<?php

declare(strict_types=1);

/**
 * Ergonomic utilities for PHP enums, including names, values, lookups, and option maps.
 *
 * This file is part of fast-forward/enum project.
 *
 * @author   Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @see      https://github.com/php-fast-forward/enum
 * @see      https://github.com/php-fast-forward/enum/issues
 * @see      https://php-fast-forward.github.io/enum/
 * @see      https://datatracker.ietf.org/doc/html/rfc2119
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

    /**
     * @return static
     */
    public function reverse(): static
    {
        return match ($this) {
            self::Ascending => self::Descending,
            self::Descending => self::Ascending,
        };
    }

    /**
     * @return bool
     */
    public function isAscending(): bool
    {
        return $this->is(self::Ascending);
    }

    /**
     * @return bool
     */
    public function isDescending(): bool
    {
        return $this->is(self::Descending);
    }

    /**
     * @return int
     */
    public function factor(): int
    {
        return match ($this) {
            self::Ascending => 1,
            self::Descending => -1,
        };
    }

    /**
     * @param int $result
     *
     * @return int
     */
    public function applyToComparisonResult(int $result): int
    {
        return $result * $this->factor();
    }
}
