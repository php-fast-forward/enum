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

namespace FastForward\Enum\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Container\ServiceLifetime;
use FastForward\Enum\Event\DispatchMode;
use FastForward\Enum\Http\Scheme;
use FastForward\Enum\Pipeline\FailureMode;
use FastForward\Enum\Process\SignalBehavior;

#[CoversClass(DispatchMode::class)]
#[CoversClass(ServiceLifetime::class)]
#[CoversClass(FailureMode::class)]
#[CoversClass(Scheme::class)]
#[CoversClass(SignalBehavior::class)]
final class DomainEnumTest extends TestCase
{
    #[Test]
    public function itProvidesEventEnums(): void
    {
        self::assertSame(['sync', 'async'], DispatchMode::values());
        self::assertTrue(DispatchMode::Sync->isSync());
        self::assertTrue(DispatchMode::Async->isAsync());
    }

    #[Test]
    public function itProvidesContainerAndPipelineEnums(): void
    {
        self::assertSame(['singleton', 'transient'], ServiceLifetime::values());
        self::assertTrue(ServiceLifetime::Singleton->isReusable());
        self::assertFalse(ServiceLifetime::Transient->isReusable());
        self::assertSame(['stop_on_failure', 'continue_on_failure'], FailureMode::values());
        self::assertTrue(FailureMode::StopOnFailure->stopsOnFailure());
    }

    #[Test]
    public function itProvidesHttpEnums(): void
    {
        self::assertSame(['http', 'https'], Scheme::values());
        self::assertSame(443, Scheme::Https->defaultPort());
        self::assertTrue(Scheme::Https->isSecure());
    }

    #[Test]
    public function itProvidesProcessEnums(): void
    {
        self::assertSame(['ignore', 'handle', 'propagate'], SignalBehavior::values());
        self::assertFalse(SignalBehavior::Ignore->isTerminalControl());
        self::assertTrue(SignalBehavior::Handle->isTerminalControl());
        self::assertTrue(SignalBehavior::Propagate->isTerminalControl());
    }
}
