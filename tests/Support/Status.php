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

namespace FastForward\Enum\Tests\Support;

use FastForward\Enum\DescribedEnumInterface;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasDescription;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNameMap;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValueMap;
use FastForward\Enum\Trait\HasValues;

enum Status: string implements DescribedEnumInterface
{
    use Comparable;
    use HasDescription;
    use HasNameLookup;
    use HasNameMap;
    use HasNames;
    use HasOptions;
    use HasValueMap;
    use HasValues;

    case Draft = 'draft';
    case Published = 'published';
}
