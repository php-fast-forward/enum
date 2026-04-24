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

use FastForward\Enum\Calendar\Weekday;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Weekday::class)]
final class WeekdayTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesWeekendsAndWeekdays(): void
    {
        self::assertTrue(Weekday::Saturday->isWeekend());
        self::assertFalse(Weekday::Wednesday->isWeekend());
        self::assertTrue(Weekday::Wednesday->isWeekday());
    }

    /**
     * @return void
     */
    #[Test]
    public function itKeepsIsoWeekOrder(): void
    {
        self::assertSame(
            [
                Weekday::Monday,
                Weekday::Tuesday,
                Weekday::Wednesday,
                Weekday::Thursday,
                Weekday::Friday,
                Weekday::Saturday,
                Weekday::Sunday,
            ],
            Weekday::ordered(),
        );
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesWeekdays(): void
    {
        self::assertSame(
            'First business day of the ISO week in most workflows and calendars.',
            Weekday::Monday->description(),
        );
    }
}
