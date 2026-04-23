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

namespace FastForward\Enum\StateMachine;

trait HasTransitions
{
    /**
     * @return array<string, list<self>>
     */
    abstract protected static function transitionMap(): array;

    /**
     * @return list<self>
     */
    protected static function initialStateCases(): array
    {
        return [];
    }

    /**
     * @return list<self>
     */
    public function allowedTransitions(): array
    {
        return self::transitionMap()[$this->name] ?? [];
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    public function assertCanTransitionTo(self $target): void
    {
        if (! $this->canTransitionTo($target)) {
            throw InvalidTransitionException::between($this, $target);
        }
    }

    public function isTerminal(): bool
    {
        return [] === $this->allowedTransitions();
    }

    public function isInitial(): bool
    {
        return in_array($this, self::initialStates(), true);
    }

    /**
     * @return list<self>
     */
    public static function initialStates(): array
    {
        $initialStates = static::initialStateCases();

        if ([] !== $initialStates) {
            return $initialStates;
        }

        $incoming = [];

        foreach (self::transitionMap() as $targets) {
            foreach ($targets as $target) {
                $incoming[$target->name] = true;
            }
        }

        return array_values(array_filter(
            self::cases(),
            static fn (self $case): bool => ! isset($incoming[$case->name]),
        ));
    }

    /**
     * @return list<self>
     */
    public static function terminalStates(): array
    {
        return array_values(array_filter(
            self::cases(),
            static fn (self $case): bool => $case->isTerminal(),
        ));
    }
}
