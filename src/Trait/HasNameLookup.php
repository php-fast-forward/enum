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

use FastForward\Enum\Helper\EnumHelper;

trait HasNameLookup
{
    /**
     * @param string $name
     *
     * @return self|null
     */
    public static function tryFromName(string $name): ?self
    {
        /** @var self|null $case */
        $case = EnumHelper::tryFromName(self::class, $name);

        return $case;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public static function fromName(string $name): self
    {
        /** @var self $case */
        $case = EnumHelper::fromName(self::class, $name);

        return $case;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function hasName(string $name): bool
    {
        return EnumHelper::hasName(self::class, $name);
    }
}
