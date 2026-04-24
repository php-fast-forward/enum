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

namespace FastForward\Enum\Tests\Process;

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Process\SignalBehavior;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SignalBehavior::class)]
#[UsesClass(EnumHelper::class)]
final class SignalBehaviorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['ignore', 'handle', 'propagate'], SignalBehavior::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesTerminalControlBehaviors(): void
    {
        self::assertFalse(SignalBehavior::Ignore->isTerminalControl());
        self::assertTrue(SignalBehavior::Handle->isTerminalControl());
        self::assertTrue(SignalBehavior::Propagate->isTerminalControl());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesSignalBehaviors(): void
    {
        self::assertSame('Signal is observed but intentionally ignored.', SignalBehavior::Ignore->description());
        self::assertSame('Signal is intercepted and processed locally.', SignalBehavior::Handle->description());
        self::assertSame(
            'Signal is forwarded to child processes or outer handlers.',
            SignalBehavior::Propagate->description(),
        );
    }
}
