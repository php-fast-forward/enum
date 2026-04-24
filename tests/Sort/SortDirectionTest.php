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

namespace FastForward\Enum\Tests\Sort;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\ReversibleInterface;
use FastForward\Enum\Sort\CaseSensitivity;
use FastForward\Enum\Sort\NullsPosition;
use FastForward\Enum\Sort\SortDirection;

#[CoversClass(CaseSensitivity::class)]
#[CoversClass(NullsPosition::class)]
#[CoversClass(SortDirection::class)]
#[UsesClass(EnumHelper::class)]
final class SortDirectionTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itProvidesEnumHelpersForSortDirection(): void
    {
        self::assertSame(['Ascending', 'Descending'], SortDirection::names());
        self::assertSame(SortDirection::Ascending, SortDirection::fromName('Ascending'));
        self::assertTrue(SortDirection::hasName('Descending'));
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesSortSpecificHelpers(): void
    {
        self::assertSame(SortDirection::Descending, SortDirection::Ascending->reverse());
        self::assertTrue(SortDirection::Ascending->isAscending());
        self::assertTrue(SortDirection::Descending->isDescending());
        self::assertSame(1, SortDirection::Ascending->factor());
        self::assertSame(-1, SortDirection::Descending->factor());
        self::assertSame(5, SortDirection::Ascending->applyToComparisonResult(5));
        self::assertSame(-5, SortDirection::Descending->applyToComparisonResult(5));
        self::assertSame(7, SortDirection::Descending->applyToComparisonResult(-7));
        self::assertInstanceOf(ReversibleInterface::class, SortDirection::Ascending);
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesNullsPositionHelpers(): void
    {
        self::assertSame(['First', 'Last'], NullsPosition::names());
        self::assertSame(NullsPosition::Last, NullsPosition::First->reverse());
        self::assertInstanceOf(ReversibleInterface::class, NullsPosition::First);
        self::assertTrue(NullsPosition::First->isFirst());
        self::assertTrue(NullsPosition::Last->isLast());
        self::assertSame(-1, NullsPosition::First->compareNullability(null, 'value'));
        self::assertSame(1, NullsPosition::Last->compareNullability(null, 'value'));
        self::assertSame(0, NullsPosition::First->compareNullability(null, null));
        self::assertSame(1, NullsPosition::First->compareNullability('value', null));
        self::assertSame(-1, NullsPosition::Last->compareNullability('value', null));
        self::assertSame(0, NullsPosition::First->compareNullability('left', 'right'));
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesCaseSensitivityHelpers(): void
    {
        self::assertSame(['Sensitive', 'Insensitive'], CaseSensitivity::names());
        self::assertSame(CaseSensitivity::Insensitive, CaseSensitivity::Sensitive->reverse());
        self::assertInstanceOf(ReversibleInterface::class, CaseSensitivity::Sensitive);
        self::assertTrue(CaseSensitivity::Sensitive->isSensitive());
        self::assertTrue(CaseSensitivity::Insensitive->isInsensitive());
        self::assertSame('hello', CaseSensitivity::Insensitive->normalize('HeLLo'));
        self::assertTrue(CaseSensitivity::Insensitive->equals('Draft', 'draft'));
        self::assertFalse(CaseSensitivity::Sensitive->equals('Draft', 'draft'));
    }
}
