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

enum Month: int implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case January = 1;
    case February = 2;
    case March = 3;
    case April = 4;
    case May = 5;
    case June = 6;
    case July = 7;
    case August = 8;
    case September = 9;
    case October = 10;
    case November = 11;
    case December = 12;

    public function description(): string
    {
        return match ($this) {
            self::January => 'Month 1 of the Gregorian calendar, commonly associated with yearly planning.',
            self::February => 'Month 2 of the Gregorian calendar, with 28 days or 29 in leap years.',
            self::March => 'Month 3 of the Gregorian calendar, often used as the end of the first quarter.',
            self::April => 'Month 4 of the Gregorian calendar, following the close of Q1 in many businesses.',
            self::May => 'Month 5 of the Gregorian calendar, typically part of the second quarter.',
            self::June => 'Month 6 of the Gregorian calendar and common end of the first half-year.',
            self::July => 'Month 7 of the Gregorian calendar and common start of the second half-year.',
            self::August => 'Month 8 of the Gregorian calendar, often used in summer scheduling contexts.',
            self::September => 'Month 9 of the Gregorian calendar and common start of many annual cycles.',
            self::October => 'Month 10 of the Gregorian calendar, typically within fourth-quarter planning.',
            self::November => 'Month 11 of the Gregorian calendar, often used for year-end preparation.',
            self::December => 'Month 12 of the Gregorian calendar and common close of fiscal or calendar years.',
        };
    }

    public function quarter(): int
    {
        return (int) ceil($this->value / 3);
    }

    public function isQuarterEnd(): bool
    {
        return $this->in([self::March, self::June, self::September, self::December]);
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [
            self::January,
            self::February,
            self::March,
            self::April,
            self::May,
            self::June,
            self::July,
            self::August,
            self::September,
            self::October,
            self::November,
            self::December,
        ];
    }
}
