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

use FastForward\Enum\Common\Priority;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Priority::class)]
final class PriorityTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itOrdersPrioritiesByWeight(): void
    {
        self::assertSame([Priority::Low, Priority::Normal, Priority::High, Priority::Critical], Priority::ordered());
    }

    /**
     * @return void
     */
    #[Test]
    public function itComparesPriorityWeights(): void
    {
        self::assertTrue(Priority::Critical->isHigherThan(Priority::Normal));
        self::assertTrue(Priority::Low->isLowerThan(Priority::High));
        self::assertSame(40, Priority::Critical->weight());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesPriorities(): void
    {
        self::assertSame(
            'Requires immediate attention due to severe business or operational impact.',
            Priority::Critical->description(),
        );
    }
}
