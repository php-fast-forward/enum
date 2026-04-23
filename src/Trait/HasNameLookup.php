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

use FastForward\Enum\Helper\EnumHelper;

trait HasNameLookup
{
    /**
     * @return self|null
     */
    public static function tryFromName(string $name): ?self
    {
        /** @var self|null $case */
        $case = EnumHelper::tryFromName(self::class, $name);

        return $case;
    }

    /**
     * @return self
     */
    public static function fromName(string $name): self
    {
        /** @var self $case */
        $case = EnumHelper::fromName(self::class, $name);

        return $case;
    }

    public static function hasName(string $name): bool
    {
        return EnumHelper::hasName(self::class, $name);
    }
}
