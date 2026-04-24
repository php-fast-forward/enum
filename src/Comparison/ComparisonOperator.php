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

namespace FastForward\Enum\Comparison;

use ValueError;
use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;

enum ComparisonOperator: string implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Equal = 'eq';
    case NotEqual = 'neq';
    case GreaterThan = 'gt';
    case GreaterThanOrEqual = 'gte';
    case LessThan = 'lt';
    case LessThanOrEqual = 'lte';
    case In = 'in';
    case NotIn = 'not_in';

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Equal => 'Matches when both operands are strictly equal.',
            self::NotEqual => 'Matches when both operands are not strictly equal.',
            self::GreaterThan => 'Matches when the left operand is greater than the right operand.',
            self::GreaterThanOrEqual => 'Matches when the left operand is greater than or equal to the right operand.',
            self::LessThan => 'Matches when the left operand is less than the right operand.',
            self::LessThanOrEqual => 'Matches when the left operand is less than or equal to the right operand.',
            self::In => 'Matches when the left operand is contained in the right-hand candidate set.',
            self::NotIn => 'Matches when the left operand is not contained in the right-hand candidate set.',
        };
    }

    /**
     * @return string
     */
    public function symbol(): string
    {
        return match ($this) {
            self::Equal => '=',
            self::NotEqual => '!=',
            self::GreaterThan => '>',
            self::GreaterThanOrEqual => '>=',
            self::LessThan => '<',
            self::LessThanOrEqual => '<=',
            self::In => 'IN',
            self::NotIn => 'NOT IN',
        };
    }

    /**
     * @return bool
     */
    public function isSetOperator(): bool
    {
        return $this->in([self::In, self::NotIn]);
    }

    /**
     * @param mixed $left
     * @param mixed $right
     *
     * @return bool
     */
    public function compare(mixed $left, mixed $right): bool
    {
        return match ($this) {
            self::Equal => $left === $right,
            self::NotEqual => $left !== $right,
            self::GreaterThan => $left > $right,
            self::GreaterThanOrEqual => $left >= $right,
            self::LessThan => $left < $right,
            self::LessThanOrEqual => $left <= $right,
            self::In => \in_array($left, $this->candidateSet($right), true),
            self::NotIn => ! \in_array($left, $this->candidateSet($right), true),
        };
    }

    /**
     * @return self
     */
    public function negate(): self
    {
        return match ($this) {
            self::Equal => self::NotEqual,
            self::NotEqual => self::Equal,
            self::GreaterThan => self::LessThanOrEqual,
            self::GreaterThanOrEqual => self::LessThan,
            self::LessThan => self::GreaterThanOrEqual,
            self::LessThanOrEqual => self::GreaterThan,
            self::In => self::NotIn,
            self::NotIn => self::In,
        };
    }

    /**
     * @param mixed $right
     *
     * @return list<mixed>
     */
    private function candidateSet(mixed $right): array
    {
        if (! \is_array($right)) {
            throw new ValueError(\sprintf('Comparison operator %s expects an array candidate set.', $this->name));
        }

        return array_values($right);
    }
}
