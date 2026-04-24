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

enum NullsPosition implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case First;
    case Last;

    /**
     * @return static
     */
    public function reverse(): static
    {
        return match ($this) {
            self::First => self::Last,
            self::Last => self::First,
        };
    }

    /**
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->is(self::First);
    }

    /**
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->is(self::Last);
    }

    /**
     * @param mixed $left
     * @param mixed $right
     *
     * @return int
     */
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
