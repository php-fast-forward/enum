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

namespace FastForward\Enum\Calendar;

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

enum Quarter: int implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Q1 = 1;
    case Q2 = 2;
    case Q3 = 3;
    case Q4 = 4;

    public function description(): string
    {
        return match ($this) {
            self::Q1 => 'First quarter of the year, covering January through March.',
            self::Q2 => 'Second quarter of the year, covering April through June.',
            self::Q3 => 'Third quarter of the year, covering July through September.',
            self::Q4 => 'Fourth quarter of the year, covering October through December.',
        };
    }

    /**
     * @return list<Month>
     */
    public function months(): array
    {
        return match ($this) {
            self::Q1 => [Month::January, Month::February, Month::March],
            self::Q2 => [Month::April, Month::May, Month::June],
            self::Q3 => [Month::July, Month::August, Month::September],
            self::Q4 => [Month::October, Month::November, Month::December],
        };
    }

    public function startMonth(): Month
    {
        return $this->months()[0];
    }

    public function endMonth(): Month
    {
        return $this->months()[2];
    }

    public function includes(Month $month): bool
    {
        return $month->quarter() === $this->value;
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [self::Q1, self::Q2, self::Q3, self::Q4];
    }

    public static function fromMonth(Month $month): self
    {
        return self::from($month->quarter());
    }
}
