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

namespace FastForward\Enum\Tests;

use DomainException;
use stdClass;
use ValueError;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\CoversClass;
use FastForward\Enum\Common\Environment;
use FastForward\Enum\Common\Month;
use FastForward\Enum\Common\Priority as CommonPriority;
use FastForward\Enum\Common\Severity;
use FastForward\Enum\Common\Weekday;
use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\StateMachine\HasTransitions;
use FastForward\Enum\StateMachine\InvalidTransitionException;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Trait\HasDescription;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;
use FastForward\Enum\Tests\Fixture\Status;
use FastForward\Enum\Tests\Fixture\Priority;
use FastForward\Enum\Tests\Fixture\Direction;
use FastForward\Enum\Tests\Fixture\DefaultLabeledStatus;
use FastForward\Enum\Tests\Fixture\ArticleWorkflow;

#[CoversClass(EnumHelper::class)]
#[UsesClass(Comparable::class)]
#[UsesClass(Environment::class)]
#[UsesClass(Month::class)]
#[UsesClass(CommonPriority::class)]
#[UsesClass(Severity::class)]
#[UsesClass(Weekday::class)]
#[UsesClass(DescribedEnumInterface::class)]
#[UsesClass(HasNameLookup::class)]
#[UsesClass(HasDescription::class)]
#[UsesClass(HasLabel::class)]
#[UsesClass(HasNameMap::class)]
#[UsesClass(HasNames::class)]
#[UsesClass(HasOptions::class)]
#[UsesClass(HasValueMap::class)]
#[UsesClass(HasValues::class)]
#[UsesClass(LabeledEnumInterface::class)]
#[UsesClass(HasTransitions::class)]
#[UsesClass(InvalidTransitionException::class)]
final class EnumTest extends TestCase
{
    #[Test]
    public function itReturnsNamesForUnitEnums(): void
    {
        self::assertSame(['North', 'South'], Direction::names());
        self::assertSame(['North', 'South'], EnumHelper::names(Direction::class));
        self::assertSame(['North', 'South'], EnumHelper::names(Direction::North));
    }

    #[Test]
    public function itReturnsValuesForBackedEnums(): void
    {
        self::assertSame(['draft', 'published'], Status::values());
        self::assertSame(['draft', 'published'], EnumHelper::values(Status::class));
        self::assertSame(['draft', 'published'], EnumHelper::values(Status::Draft));
    }

    #[Test]
    public function itBuildsMapsForNamesAndValues(): void
    {
        self::assertSame([
            'North' => Direction::North,
            'South' => Direction::South,
        ], Direction::nameMap());

        self::assertSame([
            'North' => Direction::North,
            'South' => Direction::South,
        ], EnumHelper::nameMap(Direction::North));

        self::assertSame([
            'draft' => Status::Draft,
            'published' => Status::Published,
        ], Status::valueMap());

        self::assertSame([
            'draft' => Status::Draft,
            'published' => Status::Published,
        ], EnumHelper::valueMap(Status::Draft));
    }

    #[Test]
    public function itBuildsOptionsForBackedEnums(): void
    {
        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], Status::options());

        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], EnumHelper::options(Status::class));

        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], EnumHelper::options(Status::Draft));
    }

    #[Test]
    public function itCanLookUpCasesByName(): void
    {
        self::assertTrue(Status::hasName('Draft'));
        self::assertFalse(Status::hasName('Archived'));
        self::assertSame(Status::Draft, Status::tryFromName('Draft'));
        self::assertNull(Status::tryFromName('Archived'));
        self::assertSame(Status::Published, Status::fromName('Published'));
        self::assertSame(Direction::South, EnumHelper::fromName(Direction::class, 'South'));
        self::assertSame(Direction::North, EnumHelper::fromName(Direction::South, 'North'));
    }

    #[Test]
    public function itThrowsForInvalidNames(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('"Archived" is not a valid name for enum ' . Status::class . '.');

        Status::fromName('Archived');
    }

    #[Test]
    public function itChecksForBackedValues(): void
    {
        self::assertTrue(EnumHelper::hasValue(Status::class, 'draft'));
        self::assertFalse(EnumHelper::hasValue(Status::class, 'archived'));
        self::assertTrue(EnumHelper::hasValue(Status::Draft, 'draft'));
    }

    #[Test]
    public function itRejectsNonBackedEnumClassStringsForBackedHelpers(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Enum ' . Direction::class . ' must be a backed enum.');

        EnumHelper::values(Direction::class);
    }

    #[Test]
    public function itRejectsNonEnumClassStringsForUnitHelpers(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Enum ' . stdClass::class . ' must be a unit enum.');

        EnumHelper::names(stdClass::class);
    }

    #[Test]
    public function itExposesLabelsForLabeledEnums(): void
    {
        self::assertSame(['Low priority', 'High priority'], EnumHelper::labels(Priority::class));
        self::assertSame(['Low priority', 'High priority'], EnumHelper::labels(Priority::Low));
        self::assertSame([
            'Low' => 'Low priority',
            'High' => 'High priority',
        ], EnumHelper::labelMap(Priority::class));
        self::assertSame([
            'Low' => 'Low priority',
            'High' => 'High priority',
        ], EnumHelper::labelMap(Priority::Low));
    }

    #[Test]
    public function itProvidesADefaultClassBasedLabelTrait(): void
    {
        self::assertSame(
            DefaultLabeledStatus::class . ' Draft',
            DefaultLabeledStatus::Draft->label(),
        );
        self::assertSame([
            DefaultLabeledStatus::class . ' Draft',
            DefaultLabeledStatus::class . ' Published',
        ], EnumHelper::labels(DefaultLabeledStatus::class));
    }

    #[Test]
    public function itProvidesComparableHelpers(): void
    {
        self::assertTrue(Status::Draft->is(Status::Draft));
        self::assertTrue(Status::Draft->isNot(Status::Published));
        self::assertTrue(Status::Draft->in([Status::Draft, Status::Published]));
        self::assertTrue(Status::Draft->notIn([Status::Published]));
    }

    #[Test]
    public function itProvidesADefaultDescriptionTrait(): void
    {
        self::assertSame('Draft', Status::Draft->description());
        self::assertSame('Published', Status::Published->description());
    }

    #[Test]
    public function itSupportsStateMachineStyleTransitions(): void
    {
        self::assertSame([ArticleWorkflow::Draft], ArticleWorkflow::initialStates());
        self::assertSame([ArticleWorkflow::Archived], ArticleWorkflow::terminalStates());
        self::assertTrue(ArticleWorkflow::Draft->isInitial());
        self::assertFalse(ArticleWorkflow::Reviewing->isInitial());
        self::assertTrue(ArticleWorkflow::Archived->isTerminal());
        self::assertFalse(ArticleWorkflow::Reviewing->isTerminal());
        self::assertSame(
            [ArticleWorkflow::Reviewing, ArticleWorkflow::Archived],
            ArticleWorkflow::Draft->allowedTransitions(),
        );
        self::assertTrue(ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Reviewing));
        self::assertFalse(ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Published));
    }

    #[Test]
    public function itThrowsForInvalidStateMachineTransitions(): void
    {
        $this->expectException(InvalidTransitionException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid transition from %s::%s to %s::%s.',
            ArticleWorkflow::Reviewing::class,
            ArticleWorkflow::Reviewing->name,
            ArticleWorkflow::Archived::class,
            ArticleWorkflow::Archived->name,
        ));

        ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Archived);
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
    public function itProvidesAReusablePriorityEnum(): void
    {
        self::assertSame([10, 20, 30, 40], CommonPriority::values());
        self::assertSame(CommonPriority::class . ' Critical', CommonPriority::Critical->label());
        self::assertSame(
            'Requires immediate attention due to severe business or operational impact.',
            CommonPriority::Critical->description(),
        );
        self::assertSame(
            [CommonPriority::Low, CommonPriority::Normal, CommonPriority::High, CommonPriority::Critical],
            CommonPriority::ordered(),
        );
        self::assertTrue(CommonPriority::Critical->isHigherThan(CommonPriority::Normal));
        self::assertTrue(CommonPriority::Low->isLowerThan(CommonPriority::High));
        self::assertSame(40, CommonPriority::Critical->weight());
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
}
