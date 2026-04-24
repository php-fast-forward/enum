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

    /**
     * @param self $target
     *
     * @return bool
     */
    public function canTransitionTo(self $target): bool
    {
        return \in_array($target, $this->allowedTransitions(), true);
    }

    /**
     * @param self $target
     *
     * @return void
     */
    public function assertCanTransitionTo(self $target): void
    {
        if (! $this->canTransitionTo($target)) {
            throw InvalidTransitionException::between($this, $target);
        }
    }

    /**
     * @return bool
     */
    public function isTerminal(): bool
    {
        return [] === $this->allowedTransitions();
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return \in_array($this, self::initialStates(), true);
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
            static fn(self $case): bool => ! isset($incoming[$case->name]),
        ));
    }

    /**
     * @return list<self>
     */
    public static function terminalStates(): array
    {
        return array_values(array_filter(self::cases(), static fn(self $case): bool => $case->isTerminal()));
    }
}
