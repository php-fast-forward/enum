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

namespace FastForward\Enum\Trait;

trait Comparable
{
    /**
     * @param self $other
     *
     * @return bool
     */
    public function is(self $other): bool
    {
        return $this === $other;
    }

    /**
     * @param self $other
     *
     * @return bool
     */
    public function isNot(self $other): bool
    {
        return $this !== $other;
    }

    /**
     * @param list<self> $cases
     */
    public function in(array $cases): bool
    {
        return \in_array($this, $cases, true);
    }

    /**
     * @param list<self> $cases
     */
    public function notIn(array $cases): bool
    {
        return ! $this->in($cases);
    }
}
