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

enum CaseSensitivity implements ReversibleInterface
{
    use Comparable;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;

    case Sensitive;
    case Insensitive;

    /**
     * @return static
     */
    public function reverse(): static
    {
        return match ($this) {
            self::Sensitive => self::Insensitive,
            self::Insensitive => self::Sensitive,
        };
    }

    /**
     * @return bool
     */
    public function isSensitive(): bool
    {
        return $this->is(self::Sensitive);
    }

    /**
     * @return bool
     */
    public function isInsensitive(): bool
    {
        return $this->is(self::Insensitive);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function normalize(string $value): string
    {
        return $this->isInsensitive() ? mb_strtolower($value) : $value;
    }

    /**
     * @param string $left
     * @param string $right
     *
     * @return bool
     */
    public function equals(string $left, string $right): bool
    {
        return $this->normalize($left) === $this->normalize($right);
    }
}
