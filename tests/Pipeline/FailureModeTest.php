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

namespace FastForward\Enum\Tests\Pipeline;

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Pipeline\FailureMode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FailureMode::class)]
#[UsesClass(EnumHelper::class)]
final class FailureModeTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itExposesStableBackedValues(): void
    {
        self::assertSame(['stop_on_failure', 'continue_on_failure'], FailureMode::values());
    }

    /**
     * @return void
     */
    #[Test]
    public function itIdentifiesStopOnFailureModes(): void
    {
        self::assertTrue(FailureMode::StopOnFailure->stopsOnFailure());
        self::assertFalse(FailureMode::ContinueOnFailure->stopsOnFailure());
    }

    /**
     * @return void
     */
    #[Test]
    public function itDescribesFailureModes(): void
    {
        self::assertSame(
            'Stops the pipeline immediately when a stage fails.',
            FailureMode::StopOnFailure->description()
        );
        self::assertSame(
            'Continues processing remaining stages even after a failure.',
            FailureMode::ContinueOnFailure->description(),
        );
    }
}
