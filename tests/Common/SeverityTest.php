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

use FastForward\Enum\Common\Severity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Severity::class)]
final class SeverityTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itComparesSeverityWeights(): void
    {
        self::assertTrue(Severity::Error->isAtLeast(Severity::Warning));
        self::assertFalse(Severity::Info->isAtLeast(Severity::Error));
        self::assertSame(60, Severity::Critical->weight());
    }

    /**
     * @return void
     */
    #[Test]
    public function itKeepsSeverityOrder(): void
    {
        self::assertSame(
            [Severity::Debug, Severity::Info, Severity::Notice, Severity::Warning, Severity::Error, Severity::Critical],
            Severity::ordered(),
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesSeverities(): void
    {
        self::assertSame(
            'Severe failure requiring urgent human or automated intervention.',
            Severity::Critical->description(),
        );
    }
}
