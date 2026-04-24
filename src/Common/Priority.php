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

namespace FastForward\Enum\Common;

use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;

enum Priority: int implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Low = 10;
    case Normal = 20;
    case High = 30;
    case Critical = 40;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Low => 'Can be handled later with minimal impact if delayed.',
            self::Normal => 'Default priority for routine work and expected processing order.',
            self::High => 'Needs prompt attention because delays may affect users or delivery.',
            self::Critical => 'Requires immediate attention due to severe business or operational impact.',
        };
    }

    /**
     * @return int
     */
    public function weight(): int
    {
        return $this->value;
    }

    /**
     * @param self $other
     *
     * @return bool
     */
    public function isHigherThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    /**
     * @param self $other
     *
     * @return bool
     */
    public function isLowerThan(self $other): bool
    {
        return $this->value < $other->value;
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [self::Low, self::Normal, self::High, self::Critical];
    }
}
