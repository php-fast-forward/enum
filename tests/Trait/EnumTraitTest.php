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

namespace FastForward\Enum\Tests\Trait;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasDescription;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;
use FastForward\Enum\Tests\Support\DefaultLabeledStatus;
use FastForward\Enum\Tests\Support\Direction;
use FastForward\Enum\Tests\Support\Status;

#[CoversClass(Comparable::class)]
#[UsesClass(DescribedEnumInterface::class)]
#[CoversClass(HasDescription::class)]
#[CoversClass(HasLabel::class)]
#[CoversClass(HasNameLookup::class)]
#[CoversClass(HasNameMap::class)]
#[CoversClass(HasNames::class)]
#[CoversClass(HasOptions::class)]
#[CoversClass(HasValueMap::class)]
#[CoversClass(HasValues::class)]
#[UsesClass(LabeledEnumInterface::class)]
final class EnumTraitTest extends TestCase
{
    #[Test]
    public function itProvidesUnitEnumLookupAndMappingTraits(): void
    {
        self::assertSame(['North', 'South'], Direction::names());
        self::assertSame([
            'North' => Direction::North,
            'South' => Direction::South,
        ], Direction::nameMap());
    }

    #[Test]
    public function itProvidesBackedEnumValueAndOptionTraits(): void
    {
        self::assertSame(['draft', 'published'], Status::values());
        self::assertSame([
            'Draft' => 'draft',
            'Published' => 'published',
        ], Status::options());
        self::assertSame([
            'draft' => Status::Draft,
            'published' => Status::Published,
        ], Status::valueMap());
        self::assertTrue(Status::hasName('Draft'));
        self::assertFalse(Status::hasName('Archived'));
        self::assertSame(Status::Draft, Status::tryFromName('Draft'));
        self::assertNull(Status::tryFromName('Archived'));
        self::assertSame(Status::Published, Status::fromName('Published'));
    }

    #[Test]
    public function itProvidesADefaultClassBasedLabelTrait(): void
    {
        self::assertSame(
            DefaultLabeledStatus::class . ' Draft',
            DefaultLabeledStatus::Draft->label(),
        );
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
}
