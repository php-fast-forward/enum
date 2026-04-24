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

namespace FastForward\Enum\Tests\Comparison;

use FastForward\Enum\Comparison\ComparisonOperator;
use FastForward\Enum\Helper\EnumHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ValueError;

#[CoversClass(ComparisonOperator::class)]
#[UsesClass(EnumHelper::class)]
final class ComparisonOperatorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesCompactBackedValues(): void
    {
        self::assertSame(['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'in', 'not_in'], ComparisonOperator::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itMapsOperatorsToSymbols(): void
    {
        self::assertSame(['=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN'], array_map(
            static fn(ComparisonOperator $operator): string => $operator->symbol(),
            ComparisonOperator::cases(),
        ));
    }

    /**
     * @return void
     */
    #[Test]
    public function itComparesScalarValues(): void
    {
        self::assertTrue(ComparisonOperator::Equal->compare('draft', 'draft'));
        self::assertTrue(ComparisonOperator::NotEqual->compare('draft', 'published'));
        self::assertTrue(ComparisonOperator::GreaterThan->compare(10, 5));
        self::assertTrue(ComparisonOperator::GreaterThanOrEqual->compare(10, 10));
        self::assertTrue(ComparisonOperator::LessThan->compare(5, 10));
        self::assertTrue(ComparisonOperator::LessThanOrEqual->compare(10, 10));
    }

    /**
     * @return void
     */
    #[Test]
    public function itComparesValuesAgainstCandidateSets(): void
    {
        self::assertTrue(ComparisonOperator::In->compare('draft', ['draft', 'published']));
        self::assertFalse(ComparisonOperator::NotIn->compare('draft', ['draft', 'published']));
        self::assertTrue(ComparisonOperator::In->isSetOperator());
        self::assertFalse(ComparisonOperator::Equal->isSetOperator());
    }

    /**
     * @return void
     */
    #[Test]
    public function itRejectsInvalidCandidateSets(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage('Comparison operator In expects an array candidate set.');

        ComparisonOperator::In->compare('draft', 'draft');
    }

    /**
     * @return void
     */
    #[Test]
    public function itNegatesOperators(): void
    {
        self::assertSame(ComparisonOperator::NotEqual, ComparisonOperator::Equal->negate());
        self::assertSame(ComparisonOperator::Equal, ComparisonOperator::NotEqual->negate());
        self::assertSame(ComparisonOperator::LessThanOrEqual, ComparisonOperator::GreaterThan->negate());
        self::assertSame(ComparisonOperator::LessThan, ComparisonOperator::GreaterThanOrEqual->negate());
        self::assertSame(ComparisonOperator::GreaterThanOrEqual, ComparisonOperator::LessThan->negate());
        self::assertSame(ComparisonOperator::GreaterThan, ComparisonOperator::LessThanOrEqual->negate());
        self::assertSame(ComparisonOperator::NotIn, ComparisonOperator::In->negate());
        self::assertSame(ComparisonOperator::In, ComparisonOperator::NotIn->negate());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesOperators(): void
    {
        self::assertSame('Matches when both operands are strictly equal.', ComparisonOperator::Equal->description());
    }
}
