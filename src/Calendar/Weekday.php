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

namespace FastForward\Enum\Calendar;

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

enum Weekday: int implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Monday => 'First business day of the ISO week in most workflows and calendars.',
            self::Tuesday => 'Second day of the ISO week, commonly used for regular working schedules.',
            self::Wednesday => 'Midweek day often used for routine meetings and delivery checkpoints.',
            self::Thursday => 'Late-week working day before typical end-of-week wrap-up.',
            self::Friday => 'Final common business day before the weekend in many regions.',
            self::Saturday => 'Weekend day typically treated as non-working in standard business calendars.',
            self::Sunday => 'Weekend day that closes the ISO week and often precedes planning for Monday.',
        };
    }

    /**
     * @return bool
     */
    public function isWeekend(): bool
    {
        return $this->in([self::Saturday, self::Sunday]);
    }

    /**
     * @return bool
     */
    public function isWeekday(): bool
    {
        return ! $this->isWeekend();
    }

    /**
     * @return list<self>
     */
    public static function ordered(): array
    {
        return [
            self::Monday,
            self::Tuesday,
            self::Wednesday,
            self::Thursday,
            self::Friday,
            self::Saturday,
            self::Sunday,
        ];
    }
}
