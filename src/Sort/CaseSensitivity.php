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

enum CaseSensitivity implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case Sensitive;
    case Insensitive;

    public function reverse(): static
    {
        return match ($this) {
            self::Sensitive => self::Insensitive,
            self::Insensitive => self::Sensitive,
        };
    }

    public function isSensitive(): bool
    {
        return $this->is(self::Sensitive);
    }

    public function isInsensitive(): bool
    {
        return $this->is(self::Insensitive);
    }

    public function normalize(string $value): string
    {
        return $this->isInsensitive() ? mb_strtolower($value) : $value;
    }

    public function equals(string $left, string $right): bool
    {
        return $this->normalize($left) === $this->normalize($right);
    }
}
