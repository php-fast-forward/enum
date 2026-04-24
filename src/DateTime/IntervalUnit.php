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

namespace FastForward\Enum\DateTime;

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

enum IntervalUnit: string implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Second = 'second';
    case Minute = 'minute';
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';

    public function description(): string
    {
        return match ($this) {
            self::Second => 'Represents one-second intervals for fine-grained timing and retry policies.',
            self::Minute => 'Represents one-minute intervals for short-lived scheduling and cache policies.',
            self::Hour => 'Represents one-hour intervals for operational windows and batch execution.',
            self::Day => 'Represents one-day intervals for daily schedules and retention policies.',
            self::Week => 'Represents one-week intervals for weekly planning, reports, and cleanup jobs.',
            self::Month => 'Represents one-month intervals for monthly billing, reporting, and rotation schedules.',
            self::Year => 'Represents one-year intervals for annual cycles, compliance, and archival horizons.',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::Second => 's',
            self::Minute => 'min',
            self::Hour => 'h',
            self::Day => 'd',
            self::Week => 'w',
            self::Month => 'mo',
            self::Year => 'y',
        };
    }

    public function seconds(int $amount = 1): int
    {
        return $amount * match ($this) {
            self::Second => 1,
            self::Minute => 60,
            self::Hour => 3600,
            self::Day => 86400,
            self::Week => 604800,
            self::Month => 2628000,
            self::Year => 31536000,
        };
    }

    public function isCalendarAware(): bool
    {
        return $this->in([self::Month, self::Year]);
    }
}
