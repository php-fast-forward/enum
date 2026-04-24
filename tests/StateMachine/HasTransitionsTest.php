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

namespace FastForward\Enum\Tests\StateMachine;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\StateMachine\HasTransitions;
use FastForward\Enum\StateMachine\InvalidTransitionException;
use FastForward\Enum\Tests\Support\ArticleWorkflow;

#[CoversClass(HasTransitions::class)]
#[CoversClass(InvalidTransitionException::class)]
final class HasTransitionsTest extends TestCase
{
    #[Test]
    public function itSupportsStateMachineStyleTransitions(): void
    {
        self::assertSame([ArticleWorkflow::Draft], ArticleWorkflow::initialStates());
        self::assertSame([ArticleWorkflow::Archived], ArticleWorkflow::terminalStates());
        self::assertTrue(ArticleWorkflow::Draft->isInitial());
        self::assertFalse(ArticleWorkflow::Reviewing->isInitial());
        self::assertTrue(ArticleWorkflow::Archived->isTerminal());
        self::assertFalse(ArticleWorkflow::Reviewing->isTerminal());
        self::assertSame(
            [ArticleWorkflow::Reviewing, ArticleWorkflow::Archived],
            ArticleWorkflow::Draft->allowedTransitions(),
        );
        self::assertTrue(ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Reviewing));
        self::assertFalse(ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Published));
    }

    #[Test]
    public function itThrowsForInvalidStateMachineTransitions(): void
    {
        $this->expectException(InvalidTransitionException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid transition from %s::%s to %s::%s.',
            ArticleWorkflow::Reviewing::class,
            ArticleWorkflow::Reviewing->name,
            ArticleWorkflow::Archived::class,
            ArticleWorkflow::Archived->name,
        ));

        ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Archived);
    }
}
