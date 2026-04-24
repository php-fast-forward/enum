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

namespace FastForward\Enum\Tests\Calendar;

use FastForward\Enum\Calendar\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class MonthTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itKeepsCalendarDeclarationOrder(): void
    {
        self::assertSame(Month::cases(), Month::ordered());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesTheQuarterForAMonth(): void
    {
        self::assertSame(1, Month::January->quarter());
        self::assertSame(2, Month::April->quarter());
        self::assertSame(3, Month::September->quarter());
        self::assertSame(4, Month::December->quarter());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesQuarterEndMonths(): void
    {
        self::assertTrue(Month::June->isQuarterEnd());
        self::assertFalse(Month::May->isQuarterEnd());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesMonths(): void
    {
        self::assertSame([
            'Month 1 of the Gregorian calendar, commonly associated with yearly planning.',
            'Month 2 of the Gregorian calendar, with 28 days or 29 in leap years.',
            'Month 3 of the Gregorian calendar, often used as the end of the first quarter.',
            'Month 4 of the Gregorian calendar, following the close of Q1 in many businesses.',
            'Month 5 of the Gregorian calendar, typically part of the second quarter.',
            'Month 6 of the Gregorian calendar and common end of the first half-year.',
            'Month 7 of the Gregorian calendar and common start of the second half-year.',
            'Month 8 of the Gregorian calendar, often used in summer scheduling contexts.',
            'Month 9 of the Gregorian calendar and common start of many annual cycles.',
            'Month 10 of the Gregorian calendar, typically within fourth-quarter planning.',
            'Month 11 of the Gregorian calendar, often used for year-end preparation.',
            'Month 12 of the Gregorian calendar and common close of fiscal or calendar years.',
        ], array_map(static fn(Month $month): string => $month->description(), Month::cases()));
    }
}
