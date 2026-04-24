<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/enum.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/enum
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
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
    protected static function transitionMap(): array
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
    protected static function initialStateCases(): array
    {
        return [self::Draft];
    }
}
