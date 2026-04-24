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

namespace FastForward\Enum\Tests\Outcome;

use FastForward\Enum\Outcome\Result;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Result::class)]
final class ResultTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesSuccessfulResults(): void
    {
        self::assertTrue(Result::Success->isSuccessful());
        self::assertTrue(Result::Partial->isSuccessful());
        self::assertTrue(Result::Success->isCompleteSuccess());
        self::assertTrue(Result::Failure->isFailure());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesResults(): void
    {
        self::assertSame('Operation completed only in part and may require follow-up.', Result::Partial->description());
    }
}
