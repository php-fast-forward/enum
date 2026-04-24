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

namespace FastForward\Enum\Tests\Support;

use FastForward\Enum\StateMachine\HasTransitions;

enum InferredWorkflow
{
    use HasTransitions;

    case Created;
    case Running;
    case Completed;

    /**
     * @return array<string, list<self>>
     */
    private static function transitionMap(): array
    {
        return [
            self::Created->name => [self::Running],
            self::Running->name => [self::Completed],
            self::Completed->name => [],
        ];
    }
}
