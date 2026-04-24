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

namespace FastForward\Enum\Tests\DateTime;

use FastForward\Enum\DateTime\IntervalUnit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(IntervalUnit::class)]
final class IntervalUnitTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesShortLabels(): void
    {
        self::assertSame(['s', 'min', 'h', 'd', 'w', 'mo', 'y'], array_map(
            static fn(IntervalUnit $unit): string => $unit->shortLabel(),
            IntervalUnit::cases(),
        ));
    }

    /**
     * @return void
     */
    #[Test]
    public function itConvertsUnitsToSeconds(): void
    {
        self::assertSame(1, IntervalUnit::Second->seconds());
        self::assertSame(5400, IntervalUnit::Minute->seconds(90));
        self::assertSame(7200, IntervalUnit::Hour->seconds(2));
        self::assertSame(86400, IntervalUnit::Day->seconds());
        self::assertSame(604800, IntervalUnit::Week->seconds());
        self::assertSame(2628000, IntervalUnit::Month->seconds());
        self::assertSame(31536000, IntervalUnit::Year->seconds());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesCalendarAwareUnits(): void
    {
        self::assertFalse(IntervalUnit::Week->isCalendarAware());
        self::assertTrue(IntervalUnit::Month->isCalendarAware());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesIntervalUnits(): void
    {
        self::assertSame([
            'Represents one-second intervals for fine-grained timing and retry policies.',
            'Represents one-minute intervals for short-lived scheduling and cache policies.',
            'Represents one-hour intervals for operational windows and batch execution.',
            'Represents one-day intervals for daily schedules and retention policies.',
            'Represents one-week intervals for weekly planning, reports, and cleanup jobs.',
            'Represents one-month intervals for monthly billing, reporting, and rotation schedules.',
            'Represents one-year intervals for annual cycles, compliance, and archival horizons.',
        ], array_map(static fn(IntervalUnit $unit): string => $unit->description(), IntervalUnit::cases()));
    }
}
