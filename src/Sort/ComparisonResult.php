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

enum ComparisonResult implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case LeftGreater;
    case RightGreater;
    case Equal;
    case Uncomparable;

    public static function fromComparisonResult(int $result): self
    {
        return match (true) {
            $result > 0 => self::LeftGreater,
            $result < 0 => self::RightGreater,
            default => self::Equal,
        };
    }

    public function toComparisonResult(): int
    {
        return match ($this) {
            self::LeftGreater => 1,
            self::RightGreater => -1,
            self::Equal => 0,
            // Mirrors PHP's legacy comparator fallback for values that are not logically comparable.
            self::Uncomparable => 1,
        };
    }

    public function reverse(): static
    {
        return match ($this) {
            self::LeftGreater => self::RightGreater,
            self::RightGreater => self::LeftGreater,
            default => $this,
        };
    }

    public function isComparable(): bool
    {
        return ! $this->is(self::Uncomparable);
    }
}
