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

namespace FastForward\Enum\Trait;

trait Comparable
{
    public function is(self $other): bool
    {
        return $this === $other;
    }

    public function isNot(self $other): bool
    {
        return $this !== $other;
    }

    /**
     * @param list<self> $cases
     */
    public function in(array $cases): bool
    {
        return in_array($this, $cases, true);
    }

    /**
     * @param list<self> $cases
     */
    public function notIn(array $cases): bool
    {
        return ! $this->in($cases);
    }
}
