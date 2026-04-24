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

namespace FastForward\Enum\Tests\Trait;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Helper\EnumHelper;
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

#[CoversTrait(Comparable::class)]
#[CoversTrait(HasDescription::class)]
#[CoversTrait(HasLabel::class)]
#[CoversTrait(HasNameLookup::class)]
#[CoversTrait(HasNameMap::class)]
#[CoversTrait(HasNames::class)]
#[CoversTrait(HasOptions::class)]
#[CoversTrait(HasValueMap::class)]
#[CoversTrait(HasValues::class)]
#[UsesClass(EnumHelper::class)]
final class EnumTraitTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itProvidesUnitEnumLookupAndMappingTraits(): void
    {
        self::assertSame(['North', 'South'], Direction::names());
        self::assertSame([
            'North' => Direction::North,
            'South' => Direction::South,
        ], Direction::nameMap());
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    #[Test]
    public function itProvidesADefaultClassBasedLabelTrait(): void
    {
        self::assertSame(DefaultLabeledStatus::class . ' Draft', DefaultLabeledStatus::Draft->label());
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesComparableHelpers(): void
    {
        self::assertTrue(Status::Draft->is(Status::Draft));
        self::assertTrue(Status::Draft->isNot(Status::Published));
        self::assertTrue(Status::Draft->in([Status::Draft, Status::Published]));
        self::assertTrue(Status::Draft->notIn([Status::Published]));
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesADefaultDescriptionTrait(): void
    {
        self::assertSame('Draft', Status::Draft->description());
        self::assertSame('Published', Status::Published->description());
    }
}
