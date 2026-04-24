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

namespace FastForward\Enum\Tests\Http;

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Http\Scheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Scheme::class)]
#[UsesClass(EnumHelper::class)]
final class SchemeTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['http', 'https'], Scheme::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itProvidesDefaultPorts(): void
    {
        self::assertSame(80, Scheme::Http->defaultPort());
        self::assertSame(443, Scheme::Https->defaultPort());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesSecureSchemes(): void
    {
        self::assertFalse(Scheme::Http->isSecure());
        self::assertTrue(Scheme::Https->isSecure());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesSchemes(): void
    {
        self::assertSame('Plain HTTP transport without transport-layer encryption.', Scheme::Http->description());
        self::assertSame('HTTP transport secured with TLS encryption.', Scheme::Https->description());
    }
}
