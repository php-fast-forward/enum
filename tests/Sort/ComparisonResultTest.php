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
use FastForward\Enum\Sort\ComparisonResult;

#[CoversClass(ComparisonResult::class)]
#[UsesClass(EnumHelper::class)]
final class ComparisonResultTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itProvidesNamesAndNameLookupHelpers(): void
    {
        self::assertSame(['LeftGreater', 'RightGreater', 'Equal', 'Uncomparable'], ComparisonResult::names());
        self::assertSame(ComparisonResult::Equal, ComparisonResult::fromName('Equal'));
        self::assertSame(ComparisonResult::Uncomparable, ComparisonResult::tryFromName('Uncomparable'));
        self::assertTrue(ComparisonResult::hasName('LeftGreater'));
        self::assertFalse(ComparisonResult::hasName('Ascending'));
    }

    /**
     * @return void
     */
    #[Test]
    public function itConvertsComparatorResultsToComparisonResultCases(): void
    {
        self::assertSame(ComparisonResult::LeftGreater, ComparisonResult::fromComparisonResult(1));
        self::assertSame(ComparisonResult::LeftGreater, ComparisonResult::fromComparisonResult(42));
        self::assertSame(ComparisonResult::RightGreater, ComparisonResult::fromComparisonResult(-1));
        self::assertSame(ComparisonResult::Equal, ComparisonResult::fromComparisonResult(0));
    }

    /**
     * @return void
     */
    #[Test]
    public function itConvertsComparisonResultCasesBackToComparatorResults(): void
    {
        self::assertSame(1, ComparisonResult::LeftGreater->toComparisonResult());
        self::assertSame(-1, ComparisonResult::RightGreater->toComparisonResult());
        self::assertSame(0, ComparisonResult::Equal->toComparisonResult());
        self::assertSame(1, ComparisonResult::Uncomparable->toComparisonResult());
    }

    /**
     * @return void
     */
    #[Test]
    public function itCanBeReversedAndCheckedForComparability(): void
    {
        self::assertSame(ComparisonResult::RightGreater, ComparisonResult::LeftGreater->reverse());
        self::assertSame(ComparisonResult::LeftGreater, ComparisonResult::RightGreater->reverse());
        self::assertSame(ComparisonResult::Equal, ComparisonResult::Equal->reverse());
        self::assertSame(ComparisonResult::Uncomparable, ComparisonResult::Uncomparable->reverse());
        self::assertInstanceOf(ReversibleInterface::class, ComparisonResult::LeftGreater);
        self::assertTrue(ComparisonResult::Equal->isComparable());
        self::assertFalse(ComparisonResult::Uncomparable->isComparable());
    }
}
