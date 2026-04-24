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

namespace FastForward\Enum\Tests\Logger;

use FastForward\Enum\Logger\LogLevel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(LogLevel::class)]
final class LogLevelTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itComparesLogLevelWeights(): void
    {
        self::assertTrue(LogLevel::Critical->isAtLeast(LogLevel::Warning));
        self::assertFalse(LogLevel::Info->isAtLeast(LogLevel::Error));
        self::assertSame(80, LogLevel::Emergency->weight());
    }

    /**
     * @return void
     */
    #[Test]
    public function itKeepsLogLevelOrder(): void
    {
        self::assertSame(
            [
                LogLevel::Debug,
                LogLevel::Info,
                LogLevel::Notice,
                LogLevel::Warning,
                LogLevel::Error,
                LogLevel::Critical,
                LogLevel::Alert,
                LogLevel::Emergency,
            ],
            LogLevel::ordered(),
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesLogLevels(): void
    {
        self::assertSame(
            'System is unusable and requires immediate global attention.',
            LogLevel::Emergency->description(),
        );
    }
}
