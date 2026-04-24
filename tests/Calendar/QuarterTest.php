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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Quarter::class)]
#[UsesClass(Month::class)]
final class QuarterTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itKeepsCalendarDeclarationOrder(): void
    {
        self::assertSame([Quarter::Q1, Quarter::Q2, Quarter::Q3, Quarter::Q4], Quarter::ordered());
    }

    /**
     * @return void
     */
    #[Test]
    public function itExposesTheMonthsInsideAQuarter(): void
    {
        self::assertSame([Month::April, Month::May, Month::June], Quarter::Q2->months());
        self::assertSame(Month::October, Quarter::Q4->startMonth());
        self::assertSame(Month::December, Quarter::Q4->endMonth());
    }

    /**
     * @return void
     */
    #[Test]
    public function itChecksWhetherAMonthBelongsToAQuarter(): void
    {
        self::assertTrue(Quarter::Q3->includes(Month::September));
        self::assertFalse(Quarter::Q1->includes(Month::April));
    }

    /**
     * @return void
     */
    #[Test]
    public function itResolvesAQuarterFromAMonth(): void
    {
        self::assertSame(Quarter::Q2, Quarter::fromMonth(Month::May));
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesQuarters(): void
    {
        self::assertSame([
            'First quarter of the year, covering January through March.',
            'Second quarter of the year, covering April through June.',
            'Third quarter of the year, covering July through September.',
            'Fourth quarter of the year, covering October through December.',
        ], array_map(static fn(Quarter $quarter): string => $quarter->description(), Quarter::cases()));
    }
}
