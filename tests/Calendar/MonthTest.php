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

namespace FastForward\Enum\Tests\Calendar;

use FastForward\Enum\Calendar\Month;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Month::class)]
final class MonthTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itKeepsCalendarDeclarationOrder(): void
    {
        self::assertSame(Month::cases(), Month::ordered());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesTheQuarterForAMonth(): void
    {
        self::assertSame(1, Month::January->quarter());
        self::assertSame(2, Month::April->quarter());
        self::assertSame(3, Month::September->quarter());
        self::assertSame(4, Month::December->quarter());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesQuarterEndMonths(): void
    {
        self::assertTrue(Month::June->isQuarterEnd());
        self::assertFalse(Month::May->isQuarterEnd());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesMonths(): void
    {
        self::assertSame(
            'Month 1 of the Gregorian calendar, commonly associated with yearly planning.',
            Month::January->description(),
        );
    }
}
