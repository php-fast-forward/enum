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

namespace FastForward\Enum\Tests\Container;

use FastForward\Enum\Container\ServiceLifetime;
use FastForward\Enum\Helper\EnumHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceLifetime::class)]
#[UsesClass(EnumHelper::class)]
final class ServiceLifetimeTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['singleton', 'transient'], ServiceLifetime::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesReusableLifetimes(): void
    {
        self::assertTrue(ServiceLifetime::Singleton->isReusable());
        self::assertFalse(ServiceLifetime::Transient->isReusable());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesServiceLifetimes(): void
    {
        self::assertSame(
            'One shared instance is reused for the full container lifetime.',
            ServiceLifetime::Singleton->description(),
        );
        self::assertSame('A new instance is created for each resolution.', ServiceLifetime::Transient->description());
    }
}
