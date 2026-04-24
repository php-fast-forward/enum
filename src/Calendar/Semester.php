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

enum Semester: int implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case H1 = 1;
    case H2 = 2;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::H1 => 'First half of the year, covering January through June.',
            self::H2 => 'Second half of the year, covering July through December.',
        };
    }

    /**
     * @return list<Month>
     */
    public function months(): array
    {
        return match ($this) {
            self::H1 => [Month::January, Month::February, Month::March, Month::April, Month::May, Month::June],
            self::H2 => [
                Month::July,
                Month::August,
                Month::September,
                Month::October,
                Month::November,
                Month::December,
            ],
        };
    }

    /**
     * @return list<Quarter>
     */
    public function quarters(): array
    {
        return match ($this) {
            self::H1 => [Quarter::Q1, Quarter::Q2],
            self::H2 => [Quarter::Q3, Quarter::Q4],
        };
    }

    /**
     * @return Month
     */
    public function startMonth(): Month
    {
        return $this->months()[0];
    }

    /**
     * @return Month
     */
    public function endMonth(): Month
    {
        return $this->months()[5];
    }

    /**
     * @param Month $month
     *
     * @return bool
     */
    public function includes(Month $month): bool
    {
        return $this->is(self::fromMonth($month));
    }

    /**
     * @param Month $month
     *
     * @return self
     */
    public static function fromMonth(Month $month): self
    {
        return $month->value <= Month::June->value ? self::H1 : self::H2;
    }

    /**
     * @param Quarter $quarter
     *
     * @return self
     */
    public static function fromQuarter(Quarter $quarter): self
    {
        return $quarter->value <= Quarter::Q2->value ? self::H1 : self::H2;
    }
}
