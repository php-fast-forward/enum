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
use FastForward\Enum\Trait\Comparable;

enum ArticleWorkflow: string
{
    use Comparable;
    use HasTransitions;

    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Archived = 'archived';

    /**
     * @return array<string, list<self>>
     */
    private static function transitionMap(): array
    {
        return [
            self::Draft->name => [self::Reviewing, self::Archived],
            self::Reviewing->name => [self::Published, self::Draft],
            self::Published->name => [self::Archived],
            self::Archived->name => [],
        ];
    }

    /**
     * @return list<self>
     */
    private static function initialStateCases(): array
    {
        return [self::Draft];
    }
}
