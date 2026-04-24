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

namespace FastForward\Enum\Tests\Helper;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Tests\Support\DefaultLabeledStatus;
use FastForward\Enum\Tests\Support\Direction;
use FastForward\Enum\Tests\Support\Priority;
use FastForward\Enum\Tests\Support\Status;
use ValueError;
use stdClass;

#[CoversClass(EnumHelper::class)]
#[UsesTrait(HasLabel::class)]
final class EnumHelperTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itReturnsCasesForUnitEnums(): void
    {
        self::assertSame([Direction::North, Direction::South], EnumHelper::cases(Direction::class));
        self::assertSame([Direction::North, Direction::South], EnumHelper::cases(Direction::North));
    }

    /**
     * @return void
     */
    #[Test]
    public function itReturnsNamesForUnitEnums(): void
    {
        self::assertSame(['North', 'South'], EnumHelper::names(Direction::class));
        self::assertSame(['North', 'South'], EnumHelper::names(Direction::North));
    }

    /**
     * @return void
     */
    #[Test]
    public function itReturnsValuesForBackedEnums(): void
    {
        self::assertSame(['draft', 'published'], EnumHelper::values(Status::class));
        self::assertSame(['draft', 'published'], EnumHelper::values(Status::Draft));
    }

    /**
     * @return void
     */
    #[Test]
    public function itBuildsMapsForNamesAndValues(): void
    {
        self::assertSame([
            'North' => Direction::North,
            'South' => Direction::South,
        ], EnumHelper::nameMap(Direction::North));

        self::assertSame([
            'draft' => Status::Draft,
            'published' => Status::Published,
        ], EnumHelper::valueMap(Status::Draft));
    }

    /**
     * @return void
     */
    #[Test]
    public function itBuildsOptionsForBackedEnums(): void
    {
        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], EnumHelper::options(Status::class));

        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], EnumHelper::options(Status::Draft));
    }

    /**
     * @return void
     */
    #[Test]
    public function itCanLookUpCasesByName(): void
    {
        self::assertSame(Direction::South, EnumHelper::fromName(Direction::class, 'South'));
        self::assertSame(Direction::North, EnumHelper::fromName(Direction::South, 'North'));
        self::assertTrue(EnumHelper::hasName(Direction::class, 'North'));
        self::assertFalse(EnumHelper::hasName(Direction::class, 'East'));
        self::assertNull(EnumHelper::tryFromName(Direction::class, 'East'));
    }

    /**
     * @return void
     */
    #[Test]
    public function itThrowsForInvalidNames(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('"Archived" is not a valid name for enum ' . Status::class . '.');

        EnumHelper::fromName(Status::class, 'Archived');
    }

    /**
     * @return void
     */
    #[Test]
    public function itChecksForBackedValues(): void
    {
        self::assertTrue(EnumHelper::hasValue(Status::class, 'draft'));
        self::assertFalse(EnumHelper::hasValue(Status::class, 'archived'));
        self::assertTrue(EnumHelper::hasValue(Status::Draft, 'draft'));
    }

    /**
     * @return void
     */
    #[Test]
    public function itRejectsNonBackedEnumClassStringsForBackedHelpers(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Enum ' . Direction::class . ' must be a backed enum.');

        EnumHelper::values(Direction::class);
    }

    /**
     * @return void
     */
    #[Test]
    public function itRejectsNonEnumClassStringsForUnitHelpers(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Enum ' . stdClass::class . ' must be a unit enum.');

        EnumHelper::names(stdClass::class);
    }

    /**
     * @return void
     */
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
            DefaultLabeledStatus::class . ' Draft',
            DefaultLabeledStatus::class . ' Published',
        ], EnumHelper::labels(DefaultLabeledStatus::class));
    }

    /**
     * @return void
     */
    #[Test]
    public function itRejectsNonLabeledEnumsForLabelHelpers(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Enum ' . Status::class . ' must implement ' . LabeledEnumInterface::class . '.');

        EnumHelper::labels(Status::class);
    }
}
