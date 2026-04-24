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

namespace FastForward\Enum\Tests\StateMachine;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\TestCase;
use FastForward\Enum\StateMachine\HasTransitions;
use FastForward\Enum\StateMachine\InvalidTransitionException;
use FastForward\Enum\Tests\Support\ArticleWorkflow;
use FastForward\Enum\Tests\Support\InferredWorkflow;

#[CoversTrait(HasTransitions::class)]
#[CoversClass(InvalidTransitionException::class)]
final class HasTransitionsTest extends TestCase
{
    /**
     * @return void
     */
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

        ArticleWorkflow::Draft->assertCanTransitionTo(ArticleWorkflow::Reviewing);
    }

    /**
     * @return void
     */
    #[Test]
    public function itInfersInitialStatesWhenNoInitialStateCasesAreConfigured(): void
    {
        self::assertSame([InferredWorkflow::Created], InferredWorkflow::initialStates());
        self::assertSame([InferredWorkflow::Completed], InferredWorkflow::terminalStates());
        self::assertTrue(InferredWorkflow::Created->isInitial());
        self::assertFalse(InferredWorkflow::Running->isInitial());
    }

    /**
     * @return void
     */
    #[Test]
    public function itThrowsForInvalidStateMachineTransitions(): void
    {
        $this->expectException(InvalidTransitionException::class);
        $this->expectExceptionMessage(\sprintf(
            'Invalid transition from %s::%s to %s::%s.',
            ArticleWorkflow::Reviewing::class,
            ArticleWorkflow::Reviewing->name,
            ArticleWorkflow::Archived::class,
            ArticleWorkflow::Archived->name,
        ));

        ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Archived);
    }
}
