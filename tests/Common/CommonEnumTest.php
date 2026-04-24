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

namespace FastForward\Enum\Tests\Common;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ValueError;
use FastForward\Enum\Calendar\Month;
use FastForward\Enum\Calendar\Quarter;
use FastForward\Enum\Calendar\Semester;
use FastForward\Enum\Calendar\Weekday;
use FastForward\Enum\Common\Priority;
use FastForward\Enum\Common\Severity;
use FastForward\Enum\Comparison\ComparisonOperator;
use FastForward\Enum\DateTime\IntervalUnit;
use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Logger\LogLevel;
use FastForward\Enum\Outcome\Result;
use FastForward\Enum\Runtime\Environment;

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
#[UsesClass(EnumHelper::class)]
final class CommonEnumTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itProvidesReusableComparisonOperators(): void
    {
        self::assertSame(['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'in', 'not_in'], ComparisonOperator::values());
        self::assertSame(['=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN'], array_map(
            static fn(ComparisonOperator $operator): string => $operator->symbol(),
            ComparisonOperator::cases(),
        ));
        self::assertTrue(ComparisonOperator::Equal->compare('draft', 'draft'));
        self::assertTrue(ComparisonOperator::NotEqual->compare('draft', 'published'));
        self::assertTrue(ComparisonOperator::GreaterThan->compare(10, 5));
        self::assertTrue(ComparisonOperator::GreaterThanOrEqual->compare(10, 10));
        self::assertTrue(ComparisonOperator::LessThan->compare(5, 10));
        self::assertTrue(ComparisonOperator::LessThanOrEqual->compare(10, 10));
        self::assertTrue(ComparisonOperator::In->compare('draft', ['draft', 'published']));
        self::assertFalse(ComparisonOperator::NotIn->compare('draft', ['draft', 'published']));
        self::assertTrue(ComparisonOperator::In->isSetOperator());
        self::assertFalse(ComparisonOperator::Equal->isSetOperator());
        self::assertSame(ComparisonOperator::NotEqual, ComparisonOperator::Equal->negate());
        self::assertSame(ComparisonOperator::Equal, ComparisonOperator::NotEqual->negate());
        self::assertSame(ComparisonOperator::LessThanOrEqual, ComparisonOperator::GreaterThan->negate());
        self::assertSame(ComparisonOperator::LessThan, ComparisonOperator::GreaterThanOrEqual->negate());
        self::assertSame(ComparisonOperator::GreaterThanOrEqual, ComparisonOperator::LessThan->negate());
        self::assertSame(ComparisonOperator::GreaterThan, ComparisonOperator::LessThanOrEqual->negate());
        self::assertSame(ComparisonOperator::NotIn, ComparisonOperator::In->negate());
        self::assertSame(ComparisonOperator::In, ComparisonOperator::NotIn->negate());
        self::assertSame('Matches when both operands are strictly equal.', ComparisonOperator::Equal->description());
    }

    /**
     * @return void
     */
    #[Test]
    public function itRejectsInvalidSetOperatorCandidateSets(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Comparison operator In expects an array candidate set.');

        ComparisonOperator::In->compare('draft', 'draft');
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesRuntimeAndPriorityEnums(): void
    {
        self::assertSame(['development', 'testing', 'staging', 'production'], Environment::values());
        self::assertTrue(Environment::Production->isProduction());
        self::assertTrue(Environment::Development->isPreProduction());
        self::assertTrue(Environment::Testing->isDebugFriendly());
        self::assertFalse(Environment::Production->isDebugFriendly());
        self::assertSame(
            'Live environment serving real users and production workloads.',
            Environment::Production->description()
        );
        self::assertSame([Priority::Low, Priority::Normal, Priority::High, Priority::Critical], Priority::ordered());
        self::assertTrue(Priority::Critical->isHigherThan(Priority::Normal));
        self::assertTrue(Priority::Low->isLowerThan(Priority::High));
        self::assertSame(40, Priority::Critical->weight());
        self::assertSame(
            'Requires immediate attention due to severe business or operational impact.',
            Priority::Critical->description(),
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesSeverityAndLogLevelOrdering(): void
    {
        self::assertTrue(Severity::Error->isAtLeast(Severity::Warning));
        self::assertFalse(Severity::Info->isAtLeast(Severity::Error));
        self::assertSame(60, Severity::Critical->weight());
        self::assertSame(
            'Severe failure requiring urgent human or automated intervention.',
            Severity::Critical->description()
        );
        self::assertTrue(LogLevel::Critical->isAtLeast(LogLevel::Warning));
        self::assertFalse(LogLevel::Info->isAtLeast(LogLevel::Error));
        self::assertSame(80, LogLevel::Emergency->weight());
        self::assertSame(
            [
                LogLevel::Debug,
                LogLevel::Info,
                LogLevel::Notice,
                LogLevel::Warning,
                LogLevel::Error,
                LogLevel::Critical,
                LogLevel::Alert,
                LogLevel::Emergency,
            ],
            LogLevel::ordered(),
        );
        self::assertSame(
            'System is unusable and requires immediate global attention.',
            LogLevel::Emergency->description()
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesCalendarEnums(): void
    {
        self::assertSame(Month::ordered(), Month::cases());
        self::assertSame(4, Month::December->quarter());
        self::assertTrue(Month::June->isQuarterEnd());
        self::assertFalse(Month::May->isQuarterEnd());
        self::assertSame(
            'Month 1 of the Gregorian calendar, commonly associated with yearly planning.',
            Month::January->description()
        );
        self::assertSame([Quarter::Q1, Quarter::Q2, Quarter::Q3, Quarter::Q4], Quarter::ordered());
        self::assertSame([Month::April, Month::May, Month::June], Quarter::Q2->months());
        self::assertSame(Month::October, Quarter::Q4->startMonth());
        self::assertSame(Month::December, Quarter::Q4->endMonth());
        self::assertTrue(Quarter::Q3->includes(Month::September));
        self::assertFalse(Quarter::Q1->includes(Month::April));
        self::assertSame(Quarter::Q2, Quarter::fromMonth(Month::May));
        self::assertSame('First quarter of the year, covering January through March.', Quarter::Q1->description());
        self::assertSame([Quarter::Q1, Quarter::Q2], Semester::H1->quarters());
        self::assertSame(
            [Month::January, Month::February, Month::March, Month::April, Month::May, Month::June],
            Semester::H1->months()
        );
        self::assertSame(
            [Month::July, Month::August, Month::September, Month::October, Month::November, Month::December],
            Semester::H2->months()
        );
        self::assertSame(Month::July, Semester::H2->startMonth());
        self::assertSame(Month::December, Semester::H2->endMonth());
        self::assertTrue(Semester::H1->includes(Month::March));
        self::assertFalse(Semester::H1->includes(Month::October));
        self::assertSame(Semester::H1, Semester::fromMonth(Month::May));
        self::assertSame(Semester::H2, Semester::fromQuarter(Quarter::Q4));
        self::assertSame('First half of the year, covering January through June.', Semester::H1->description());
        self::assertTrue(Weekday::Saturday->isWeekend());
        self::assertFalse(Weekday::Wednesday->isWeekend());
        self::assertTrue(Weekday::Wednesday->isWeekday());
        self::assertSame(
            [
                Weekday::Monday,
                Weekday::Tuesday,
                Weekday::Wednesday,
                Weekday::Thursday,
                Weekday::Friday,
                Weekday::Saturday,
                Weekday::Sunday,
            ],
            Weekday::ordered()
        );
        self::assertSame(
            'First business day of the ISO week in most workflows and calendars.',
            Weekday::Monday->description()
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesIntervalUnitsAndOutcomeResults(): void
    {
        self::assertSame(['s', 'min', 'h', 'd', 'w', 'mo', 'y'], array_map(
            static fn(IntervalUnit $unit): string => $unit->shortLabel(),
            IntervalUnit::cases(),
        ));
        self::assertSame(1, IntervalUnit::Second->seconds());
        self::assertSame(5400, IntervalUnit::Minute->seconds(90));
        self::assertSame(7200, IntervalUnit::Hour->seconds(2));
        self::assertSame(86400, IntervalUnit::Day->seconds());
        self::assertSame(604800, IntervalUnit::Week->seconds());
        self::assertSame(2628000, IntervalUnit::Month->seconds());
        self::assertSame(31536000, IntervalUnit::Year->seconds());
        self::assertFalse(IntervalUnit::Week->isCalendarAware());
        self::assertTrue(IntervalUnit::Month->isCalendarAware());
        self::assertSame(
            'Represents one-second intervals for fine-grained timing and retry policies.',
            IntervalUnit::Second->description()
        );
        self::assertTrue(Result::Success->isSuccessful());
        self::assertTrue(Result::Partial->isSuccessful());
        self::assertTrue(Result::Success->isCompleteSuccess());
        self::assertTrue(Result::Failure->isFailure());
        self::assertSame('Operation completed only in part and may require follow-up.', Result::Partial->description());
    }
}
