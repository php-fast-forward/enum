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

namespace FastForward\Enum\Tests\Sort;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\ReversibleInterface;
use FastForward\Enum\Sort\ComparisonResult;

#[CoversClass(ComparisonResult::class)]
final class ComparisonResultTest extends TestCase
{
    #[Test]
    public function itProvidesNamesAndNameLookupHelpers(): void
    {
        self::assertSame(
            ['LeftGreater', 'RightGreater', 'Equal', 'Uncomparable'],
            ComparisonResult::names(),
        );
        self::assertSame(ComparisonResult::Equal, ComparisonResult::fromName('Equal'));
        self::assertSame(ComparisonResult::Uncomparable, ComparisonResult::tryFromName('Uncomparable'));
        self::assertTrue(ComparisonResult::hasName('LeftGreater'));
        self::assertFalse(ComparisonResult::hasName('Ascending'));
    }

    #[Test]
    public function itConvertsComparatorResultsToComparisonResultCases(): void
    {
        self::assertSame(ComparisonResult::LeftGreater, ComparisonResult::fromComparisonResult(1));
        self::assertSame(ComparisonResult::LeftGreater, ComparisonResult::fromComparisonResult(42));
        self::assertSame(ComparisonResult::RightGreater, ComparisonResult::fromComparisonResult(-1));
        self::assertSame(ComparisonResult::Equal, ComparisonResult::fromComparisonResult(0));
    }

    #[Test]
    public function itConvertsComparisonResultCasesBackToComparatorResults(): void
    {
        self::assertSame(1, ComparisonResult::LeftGreater->toComparisonResult());
        self::assertSame(-1, ComparisonResult::RightGreater->toComparisonResult());
        self::assertSame(0, ComparisonResult::Equal->toComparisonResult());
        self::assertSame(1, ComparisonResult::Uncomparable->toComparisonResult());
    }

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
