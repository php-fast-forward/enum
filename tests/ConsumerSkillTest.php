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

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

#[CoversNothing]
final class ConsumerSkillTest extends TestCase
{
    /**
     * @return void
     */
    public function testBundledConsumerIntegration(): void
    {
        $root = \dirname(__DIR__);
        $process = new Process([
            \PHP_BINARY,
            $root . '/resources/skills/fast-forward-enum/examples/integration.php',
            $root . '/vendor/autoload.php',
        ], $root, [
            'XDEBUG_MODE' => 'off',
        ]);
        $process->setTimeout(20);
        $process->run();

        self::assertTrue($process->isSuccessful(), $process->getErrorOutput() . $process->getOutput());
        self::assertStringContainsString('fast-forward-enum: ok', $process->getOutput());
    }
}
