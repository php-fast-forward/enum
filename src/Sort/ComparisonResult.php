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

enum ComparisonResult implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case LeftGreater;
    case RightGreater;
    case Equal;
    case Incomparable;

    /**
     * @param int $result
     *
     * @return self
     */
    public static function fromComparisonResult(int $result): self
    {
        return match (true) {
            $result > 0 => self::LeftGreater,
            $result < 0 => self::RightGreater,
            default => self::Equal,
        };
    }

    /**
     * @return int
     */
    public function toComparisonResult(): int
    {
        return match ($this) {
            self::LeftGreater => 1,
            self::RightGreater => -1,
            self::Equal => 0,
            // Mirrors PHP's legacy comparator fallback for values that are not logically comparable.
            self::Incomparable => 1,
        };
    }

    /**
     * @return static
     */
    public function reverse(): static
    {
        return match ($this) {
            self::LeftGreater => self::RightGreater,
            self::RightGreater => self::LeftGreater,
            default => $this,
        };
    }

    /**
     * @return bool
     */
    public function isComparable(): bool
    {
        return ! $this->is(self::Incomparable);
    }
}
