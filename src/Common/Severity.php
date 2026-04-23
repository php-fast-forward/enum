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

namespace FastForward\Enum\Common;

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

enum Severity: string implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Debug = 'debug';
    case Info = 'info';
    case Notice = 'notice';
    case Warning = 'warning';
    case Error = 'error';
    case Critical = 'critical';

    public function description(): string
    {
        return match ($this) {
            self::Debug => 'Diagnostic information intended for development and troubleshooting.',
            self::Info => 'Informational event describing normal application flow or notable activity.',
            self::Notice => 'Significant but expected condition that may deserve attention soon.',
            self::Warning => 'Potential problem that should be reviewed before it escalates.',
            self::Error => 'Failure condition that affected part of the current operation.',
            self::Critical => 'Severe failure requiring urgent human or automated intervention.',
        };
    }

    public function weight(): int
    {
        return match ($this) {
            self::Debug => 10,
            self::Info => 20,
            self::Notice => 30,
            self::Warning => 40,
            self::Error => 50,
            self::Critical => 60,
        };
    }

    public function isAtLeast(self $severity): bool
    {
        return $this->weight() >= $severity->weight();
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [self::Debug, self::Info, self::Notice, self::Warning, self::Error, self::Critical];
    }
}
