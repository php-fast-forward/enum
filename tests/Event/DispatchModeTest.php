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

namespace FastForward\Enum\Tests\Event;

use FastForward\Enum\Event\DispatchMode;
use FastForward\Enum\Helper\EnumHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DispatchMode::class)]
#[UsesClass(EnumHelper::class)]
final class DispatchModeTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['sync', 'async'], DispatchMode::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesSyncAndAsyncDispatch(): void
    {
        self::assertTrue(DispatchMode::Sync->isSync());
        self::assertFalse(DispatchMode::Async->isSync());
        self::assertTrue(DispatchMode::Async->isAsync());
        self::assertFalse(DispatchMode::Sync->isAsync());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesDispatchModes(): void
    {
        self::assertSame(
            'Dispatches listeners immediately within the current execution flow.',
            DispatchMode::Sync->description(),
        );
        self::assertSame(
            'Dispatches listeners through a deferred or queued execution path.',
            DispatchMode::Async->description(),
        );
    }
}
