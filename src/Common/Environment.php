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

enum Environment: string implements DescribedEnumInterface, LabeledEnumInterface
{
    use Comparable;
    use HasLabel;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Development = 'development';
    case Testing = 'testing';
    case Staging = 'staging';
    case Production = 'production';

    public function description(): string
    {
        return match ($this) {
            self::Development => 'Local development environment with fast feedback and debugging enabled.',
            self::Testing => 'Automated test environment intended for repeatable checks and validation.',
            self::Staging => 'Pre-production environment used to verify releases before going live.',
            self::Production => 'Live environment serving real users and production workloads.',
        };
    }

    public function isProduction(): bool
    {
        return self::Production === $this;
    }

    public function isPreProduction(): bool
    {
        return $this->in([self::Development, self::Testing, self::Staging]);
    }

    public function isDebugFriendly(): bool
    {
        return $this->in([self::Development, self::Testing]);
    }
}
