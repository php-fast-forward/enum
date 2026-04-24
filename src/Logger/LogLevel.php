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

namespace FastForward\Enum\Logger;

use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\LabeledEnumInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasLabel;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;

enum LogLevel: string implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Emergency = 'emergency';
    case Alert = 'alert';
    case Critical = 'critical';
    case Error = 'error';
    case Warning = 'warning';
    case Notice = 'notice';
    case Info = 'info';
    case Debug = 'debug';

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Emergency => 'System is unusable and requires immediate global attention.',
            self::Alert => 'Action must be taken immediately to avoid severe service disruption.',
            self::Critical => 'Critical condition indicating serious failure in a core capability.',
            self::Error => 'Runtime error indicating part of the current operation failed.',
            self::Warning => 'Potential issue that should be reviewed before it becomes an error.',
            self::Notice => 'Normal but noteworthy event that may deserve operational awareness.',
            self::Info => 'Informational event describing expected application flow.',
            self::Debug => 'Verbose diagnostic information intended for debugging and development.',
        };
    }

    /**
     * @return int
     */
    public function weight(): int
    {
        return match ($this) {
            self::Debug => 10,
            self::Info => 20,
            self::Notice => 30,
            self::Warning => 40,
            self::Error => 50,
            self::Critical => 60,
            self::Alert => 70,
            self::Emergency => 80,
        };
    }

    /**
     * @param self $level
     *
     * @return bool
     */
    public function isAtLeast(self $level): bool
    {
        return $this->weight() >= $level->weight();
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [
            self::Debug,
            self::Info,
            self::Notice,
            self::Warning,
            self::Error,
            self::Critical,
            self::Alert,
            self::Emergency,
        ];
    }
}
