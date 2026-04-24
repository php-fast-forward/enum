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

namespace FastForward\Enum\Helper;

use BackedEnum;
use UnitEnum;
use ValueError;
use FastForward\Enum\LabeledEnumInterface;

final class EnumHelper
{
    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return list<T>
     */
    public static function cases(string|UnitEnum $enum): array
    {
        $enumClass = self::unitEnumClass($enum);

        return $enumClass::cases();
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return list<string>
     */
    public static function names(string|UnitEnum $enum): array
    {
        $enumClass = self::unitEnumClass($enum);

        return array_map(static fn(UnitEnum $case): string => $case->name, $enumClass::cases());
    }

    /**
     * @template T of BackedEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return list<int|string>
     */
    public static function values(string|BackedEnum $enum): array
    {
        $enumClass = self::backedEnumClass($enum);

        return array_map(static fn(BackedEnum $case): int|string => $case->value, $enumClass::cases());
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return array<string, T>
     */
    public static function nameMap(string|UnitEnum $enum): array
    {
        $enumClass = self::unitEnumClass($enum);
        $map = [];

        foreach ($enumClass::cases() as $case) {
            $map[$case->name] = $case;
        }

        return $map;
    }

    /**
     * @template T of BackedEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return array<int|string, T>
     */
    public static function valueMap(string|BackedEnum $enum): array
    {
        $enumClass = self::backedEnumClass($enum);
        $map = [];

        foreach ($enumClass::cases() as $case) {
            $map[$case->value] = $case;
        }

        return $map;
    }

    /**
     * @template T of BackedEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return array<string, int|string>
     */
    public static function options(string|BackedEnum $enum): array
    {
        $enumClass = self::backedEnumClass($enum);
        $options = [];

        foreach ($enumClass::cases() as $case) {
            $options[$case->name] = $case->value;
        }

        return $options;
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     * @param string $name
     */
    public static function hasName(string|UnitEnum $enum, string $name): bool
    {
        return isset(self::nameMap($enum)[$name]);
    }

    /**
     * @template T of BackedEnum
     *
     * @param class-string<T>|T $enum
     * @param int|string $value
     */
    public static function hasValue(string|BackedEnum $enum, int|string $value): bool
    {
        $enumClass = self::backedEnumClass($enum);

        return null !== $enumClass::tryFrom($value);
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     * @param string $name
     *
     * @return T|null
     */
    public static function tryFromName(string|UnitEnum $enum, string $name): ?UnitEnum
    {
        return self::nameMap($enum)[$name] ?? null;
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     * @param string $name
     *
     * @return T
     */
    public static function fromName(string|UnitEnum $enum, string $name): UnitEnum
    {
        $enumClass = self::unitEnumClass($enum);

        return self::tryFromName($enumClass, $name)
            ?? throw new ValueError(\sprintf('"%s" is not a valid name for enum %s.', $name, $enumClass));
    }

    /**
     * @template T of UnitEnum&LabeledEnumInterface
     *
     * @param class-string<T>|T $enum
     *
     * @return list<string>
     */
    public static function labels(string|UnitEnum $enum): array
    {
        $enumClass = self::labeledEnumClass($enum);

        return array_map(static fn(LabeledEnumInterface $case): string => $case->label(), $enumClass::cases());
    }

    /**
     * @template T of UnitEnum&LabeledEnumInterface
     *
     * @param class-string<T>|T $enum
     *
     * @return array<string, string>
     */
    public static function labelMap(string|UnitEnum $enum): array
    {
        $enumClass = self::labeledEnumClass($enum);
        $map = [];

        foreach ($enumClass::cases() as $case) {
            $map[$case->name] = $case->label();
        }

        return $map;
    }

    /**
     * @template T of UnitEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return class-string<T>
     */
    private static function unitEnumClass(string|UnitEnum $enum): string
    {
        /** @var class-string<T> $enumClass */
        $enumClass = \is_string($enum) ? $enum : $enum::class;

        if (! enum_exists($enumClass) || ! is_subclass_of($enumClass, UnitEnum::class, true)) {
            throw new ValueError(\sprintf('Enum %s must be a unit enum.', $enumClass));
        }

        return $enumClass;
    }

    /**
     * @template T of BackedEnum
     *
     * @param class-string<T>|T $enum
     *
     * @return class-string<T>
     */
    private static function backedEnumClass(string|BackedEnum $enum): string
    {
        /** @var class-string<T> $enumClass */
        $enumClass = \is_string($enum) ? $enum : $enum::class;

        if (! enum_exists($enumClass) || ! is_subclass_of($enumClass, BackedEnum::class, true)) {
            throw new ValueError(\sprintf('Enum %s must be a backed enum.', $enumClass));
        }

        return $enumClass;
    }

    /**
     * @template T of UnitEnum&LabeledEnumInterface
     *
     * @param class-string<T>|T $enum
     *
     * @return class-string<T>
     */
    private static function labeledEnumClass(string|UnitEnum $enum): string
    {
        /** @var class-string<T> $enumClass */
        $enumClass = self::unitEnumClass($enum);

        if (! is_subclass_of($enumClass, LabeledEnumInterface::class, true)) {
            throw new ValueError(\sprintf('Enum %s must implement %s.', $enumClass, LabeledEnumInterface::class));
        }

        return $enumClass;
    }
}
