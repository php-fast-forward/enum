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

namespace FastForward\Enum\Tests\Runtime;

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Runtime\Environment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Environment::class)]
#[UsesClass(EnumHelper::class)]
final class EnvironmentTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['development', 'testing', 'staging', 'production'], Environment::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesProductionAndPreProductionEnvironments(): void
    {
        self::assertTrue(Environment::Production->isProduction());
        self::assertTrue(Environment::Development->isPreProduction());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesDebugFriendlyEnvironments(): void
    {
        self::assertTrue(Environment::Testing->isDebugFriendly());
        self::assertFalse(Environment::Production->isDebugFriendly());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesEnvironments(): void
    {
        self::assertSame(
            'Live environment serving real users and production workloads.',
            Environment::Production->description(),
        );
    }
}
