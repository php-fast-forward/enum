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
use FastForward\Enum\Calendar\Quarter;
use FastForward\Enum\Calendar\Semester;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Semester::class)]
#[UsesClass(Month::class)]
#[UsesClass(Quarter::class)]
final class SemesterTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesTheQuartersInsideASemester(): void
    {
        self::assertSame([Quarter::Q1, Quarter::Q2], Semester::H1->quarters());
    }

    /**
     * @return void
     */
    #[Test]
    public function itExposesTheMonthsInsideASemester(): void
    {
        self::assertSame(
            [Month::January, Month::February, Month::March, Month::April, Month::May, Month::June],
            Semester::H1->months(),
        );
        self::assertSame(
            [Month::July, Month::August, Month::September, Month::October, Month::November, Month::December],
            Semester::H2->months(),
        );
        self::assertSame(Month::July, Semester::H2->startMonth());
        self::assertSame(Month::December, Semester::H2->endMonth());
    }

    /**
     * @return void
     */
    #[Test]
    public function itChecksWhetherAMonthBelongsToASemester(): void
    {
        self::assertTrue(Semester::H1->includes(Month::March));
        self::assertFalse(Semester::H1->includes(Month::October));
    }

    /**
     * @return void
     */
    #[Test]
    public function itResolvesASemesterFromCalendarUnits(): void
    {
        self::assertSame(Semester::H1, Semester::fromMonth(Month::May));
        self::assertSame(Semester::H2, Semester::fromQuarter(Quarter::Q4));
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesSemesters(): void
    {
        self::assertSame('First half of the year, covering January through June.', Semester::H1->description());
    }
}
