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

namespace FastForward\Enum\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\Container\ServiceLifetime;
use FastForward\Enum\Event\DispatchMode;
use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Http\Scheme;
use FastForward\Enum\Pipeline\FailureMode;
use FastForward\Enum\Process\SignalBehavior;

#[CoversClass(DispatchMode::class)]
#[CoversClass(ServiceLifetime::class)]
#[CoversClass(FailureMode::class)]
#[CoversClass(Scheme::class)]
#[CoversClass(SignalBehavior::class)]
#[UsesClass(EnumHelper::class)]
final class DomainEnumTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itProvidesEventEnums(): void
    {
        self::assertSame(['sync', 'async'], DispatchMode::values());
        self::assertTrue(DispatchMode::Sync->isSync());
        self::assertFalse(DispatchMode::Async->isSync());
        self::assertTrue(DispatchMode::Async->isAsync());
        self::assertFalse(DispatchMode::Sync->isAsync());
        self::assertSame(
            'Dispatches listeners immediately within the current execution flow.',
            DispatchMode::Sync->description()
        );
        self::assertSame(
            'Dispatches listeners through a deferred or queued execution path.',
            DispatchMode::Async->description()
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesContainerAndPipelineEnums(): void
    {
        self::assertSame(['singleton', 'transient'], ServiceLifetime::values());
        self::assertTrue(ServiceLifetime::Singleton->isReusable());
        self::assertFalse(ServiceLifetime::Transient->isReusable());
        self::assertSame(
            'One shared instance is reused for the full container lifetime.',
            ServiceLifetime::Singleton->description()
        );
        self::assertSame('A new instance is created for each resolution.', ServiceLifetime::Transient->description());
        self::assertSame(['stop_on_failure', 'continue_on_failure'], FailureMode::values());
        self::assertTrue(FailureMode::StopOnFailure->stopsOnFailure());
        self::assertFalse(FailureMode::ContinueOnFailure->stopsOnFailure());
        self::assertSame(
            'Stops the pipeline immediately when a stage fails.',
            FailureMode::StopOnFailure->description()
        );
        self::assertSame(
            'Continues processing remaining stages even after a failure.',
            FailureMode::ContinueOnFailure->description()
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesHttpEnums(): void
    {
        self::assertSame(['http', 'https'], Scheme::values());
        self::assertSame(80, Scheme::Http->defaultPort());
        self::assertSame(443, Scheme::Https->defaultPort());
        self::assertFalse(Scheme::Http->isSecure());
        self::assertTrue(Scheme::Https->isSecure());
        self::assertSame('Plain HTTP transport without transport-layer encryption.', Scheme::Http->description());
        self::assertSame('HTTP transport secured with TLS encryption.', Scheme::Https->description());
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesProcessEnums(): void
    {
        self::assertSame(['ignore', 'handle', 'propagate'], SignalBehavior::values());
        self::assertFalse(SignalBehavior::Ignore->isTerminalControl());
        self::assertTrue(SignalBehavior::Handle->isTerminalControl());
        self::assertTrue(SignalBehavior::Propagate->isTerminalControl());
        self::assertSame('Signal is observed but intentionally ignored.', SignalBehavior::Ignore->description());
        self::assertSame('Signal is intercepted and processed locally.', SignalBehavior::Handle->description());
        self::assertSame(
            'Signal is forwarded to child processes or outer handlers.',
            SignalBehavior::Propagate->description()
        );
    }
}
