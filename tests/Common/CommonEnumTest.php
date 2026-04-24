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

namespace FastForward\Enum\Tests\Common;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Calendar\Month;
use FastForward\Enum\Calendar\Quarter;
use FastForward\Enum\Calendar\Semester;
use FastForward\Enum\Calendar\Weekday;
use FastForward\Enum\Comparison\ComparisonOperator;
use FastForward\Enum\DateTime\IntervalUnit;
use FastForward\Enum\Logger\LogLevel;
use FastForward\Enum\Common\Priority;
use FastForward\Enum\Outcome\Result;
use FastForward\Enum\Runtime\Environment;
use FastForward\Enum\Common\Severity;

#[CoversClass(ComparisonOperator::class)]
#[CoversClass(Environment::class)]
#[CoversClass(IntervalUnit::class)]
#[CoversClass(LogLevel::class)]
#[CoversClass(Month::class)]
#[CoversClass(Priority::class)]
#[CoversClass(Quarter::class)]
#[CoversClass(Result::class)]
#[CoversClass(Semester::class)]
#[CoversClass(Severity::class)]
#[CoversClass(Weekday::class)]
final class CommonEnumTest extends TestCase
{
    #[Test]
    public function itProvidesAReusableComparisonOperatorEnum(): void
    {
        self::assertSame(['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'in', 'not_in'], ComparisonOperator::values());
        self::assertSame('>=', ComparisonOperator::GreaterThanOrEqual->symbol());
        self::assertTrue(ComparisonOperator::GreaterThan->compare(10, 5));
        self::assertTrue(ComparisonOperator::In->compare('draft', ['draft', 'published']));
        self::assertFalse(ComparisonOperator::NotIn->compare('draft', ['draft', 'published']));
        self::assertTrue(ComparisonOperator::In->isSetOperator());
        self::assertSame(ComparisonOperator::LessThan, ComparisonOperator::GreaterThanOrEqual->negate());
    }

    #[Test]
    public function itProvidesAReusableEnvironmentEnum(): void
    {
        self::assertSame(['development', 'testing', 'staging', 'production'], Environment::values());
        self::assertSame(Environment::class . ' Production', Environment::Production->label());
        self::assertSame(
            'Live environment serving real users and production workloads.',
            Environment::Production->description(),
        );
        self::assertTrue(Environment::Production->isProduction());
        self::assertTrue(Environment::Development->isPreProduction());
        self::assertTrue(Environment::Testing->isDebugFriendly());
        self::assertFalse(Environment::Production->isDebugFriendly());
        self::assertSame(Environment::Staging, Environment::fromName('Staging'));
    }

    #[Test]
    public function itProvidesAReusableIntervalUnitEnum(): void
    {
        self::assertSame(
            ['second', 'minute', 'hour', 'day', 'week', 'month', 'year'],
            IntervalUnit::values(),
        );
        self::assertSame('min', IntervalUnit::Minute->shortLabel());
        self::assertSame(5400, IntervalUnit::Minute->seconds(90));
        self::assertFalse(IntervalUnit::Week->isCalendarAware());
        self::assertTrue(IntervalUnit::Month->isCalendarAware());
    }

    #[Test]
    public function itProvidesAReusablePriorityEnum(): void
    {
        self::assertSame([10, 20, 30, 40], Priority::values());
        self::assertSame(Priority::class . ' Critical', Priority::Critical->label());
        self::assertSame(
            'Requires immediate attention due to severe business or operational impact.',
            Priority::Critical->description(),
        );
        self::assertSame(
            [Priority::Low, Priority::Normal, Priority::High, Priority::Critical],
            Priority::ordered(),
        );
        self::assertTrue(Priority::Critical->isHigherThan(Priority::Normal));
        self::assertTrue(Priority::Low->isLowerThan(Priority::High));
        self::assertSame(40, Priority::Critical->weight());
    }

    #[Test]
    public function itProvidesAReusableSeverityEnum(): void
    {
        self::assertSame(['debug', 'info', 'notice', 'warning', 'error', 'critical'], Severity::values());
        self::assertTrue(Severity::Error->isAtLeast(Severity::Warning));
        self::assertFalse(Severity::Info->isAtLeast(Severity::Error));
        self::assertSame(60, Severity::Critical->weight());
        self::assertSame(
            'Severe failure requiring urgent human or automated intervention.',
            Severity::Critical->description(),
        );
    }

    #[Test]
    public function itProvidesAReusableWeekdayEnum(): void
    {
        self::assertSame([1, 2, 3, 4, 5, 6, 7], Weekday::values());
        self::assertTrue(Weekday::Saturday->isWeekend());
        self::assertFalse(Weekday::Wednesday->isWeekend());
        self::assertTrue(Weekday::Wednesday->isWeekday());
        self::assertSame(
            [Weekday::Monday, Weekday::Tuesday, Weekday::Wednesday, Weekday::Thursday, Weekday::Friday, Weekday::Saturday, Weekday::Sunday],
            Weekday::ordered(),
        );
    }

    #[Test]
    public function itProvidesAReusableMonthEnum(): void
    {
        self::assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], Month::values());
        self::assertSame(4, Month::December->quarter());
        self::assertTrue(Month::June->isQuarterEnd());
        self::assertFalse(Month::May->isQuarterEnd());
        self::assertSame(
            'Month 12 of the Gregorian calendar and common close of fiscal or calendar years.',
            Month::December->description(),
        );
    }

    #[Test]
    public function itProvidesAReusableLogLevelEnum(): void
    {
        self::assertSame(
            ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'],
            LogLevel::values(),
        );
        self::assertTrue(LogLevel::Critical->isAtLeast(LogLevel::Warning));
        self::assertFalse(LogLevel::Info->isAtLeast(LogLevel::Error));
        self::assertSame(80, LogLevel::Emergency->weight());
        self::assertSame(
            [LogLevel::Debug, LogLevel::Info, LogLevel::Notice, LogLevel::Warning, LogLevel::Error, LogLevel::Critical, LogLevel::Alert, LogLevel::Emergency],
            LogLevel::ordered(),
        );
    }

    #[Test]
    public function itProvidesAReusableQuarterEnum(): void
    {
        self::assertSame([1, 2, 3, 4], Quarter::values());
        self::assertSame([Month::April, Month::May, Month::June], Quarter::Q2->months());
        self::assertSame(Month::October, Quarter::Q4->startMonth());
        self::assertSame(Month::December, Quarter::Q4->endMonth());
        self::assertTrue(Quarter::Q3->includes(Month::September));
        self::assertFalse(Quarter::Q1->includes(Month::April));
        self::assertSame(Quarter::Q2, Quarter::fromMonth(Month::May));
    }

    #[Test]
    public function itProvidesAReusableResultEnum(): void
    {
        self::assertSame(['success', 'partial', 'failure'], Result::values());
        self::assertTrue(Result::Success->isSuccessful());
        self::assertTrue(Result::Partial->isSuccessful());
        self::assertTrue(Result::Success->isCompleteSuccess());
        self::assertTrue(Result::Failure->isFailure());
        self::assertSame('Operation completed only in part and may require follow-up.', Result::Partial->description());
    }

    #[Test]
    public function itProvidesAReusableSemesterEnum(): void
    {
        self::assertSame([1, 2], Semester::values());
        self::assertSame([Quarter::Q1, Quarter::Q2], Semester::H1->quarters());
        self::assertSame(Month::July, Semester::H2->startMonth());
        self::assertSame(Month::December, Semester::H2->endMonth());
        self::assertTrue(Semester::H1->includes(Month::March));
        self::assertFalse(Semester::H1->includes(Month::October));
        self::assertSame(Semester::H1, Semester::fromMonth(Month::May));
        self::assertSame(Semester::H2, Semester::fromQuarter(Quarter::Q4));
    }
}
