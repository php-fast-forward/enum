# Fast Forward Enum

[![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue.svg)](https://www.php.net/releases/)
[![License](https://img.shields.io/github/license/php-fast-forward/enum)](LICENSE)

Ergonomic utilities for PHP enums with a small, framework-agnostic API. The package focuses on the
pieces the engine does not provide out of the box yet, such as `values()`, name lookups, and ready
to use option maps.

## Features

- `Trait\HasValues` for backed enums
- `Trait\HasNames` for any enum
- `Trait\HasNameLookup` with `fromName()`, `tryFromName()`, and `hasName()`
- `Trait\HasOptions`, `Trait\HasNameMap`, and `Trait\HasValueMap` for common integration scenarios
- `Trait\Comparable` for case comparisons and membership checks
- `Trait\HasDescription` for readable descriptions based on the case name
- `StateMachine\HasTransitions` for explicit enum-based workflow transitions
- Ready-to-use enums in `Common\`, including `Environment`, `Priority`, `Severity`, `Weekday`, and `Month`
- Static helper methods through [`Helper\EnumHelper`](src/Helper/EnumHelper.php)
- Optional [`LabeledEnumInterface`](src/LabeledEnumInterface.php) for labels without framework lock-in

## Installation

```bash
composer require fast-forward/enum
```

## Usage

```php
<?php

declare(strict_types=1);

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\Trait\Comparable;
use FastForward\Enum\Trait\HasDescription;
use FastForward\Enum\Trait\HasNameLookup;
use FastForward\Enum\Trait\HasNames;
use FastForward\Enum\Trait\HasOptions;
use FastForward\Enum\Trait\HasValues;

enum Status: string
{
    use Comparable;
    use HasDescription;
    use HasNameLookup;
    use HasNames;
    use HasOptions;
    use HasValues;

    case Draft = 'draft';
    case Published = 'published';
}

Status::values(); // ['draft', 'published']
Status::names(); // ['Draft', 'Published']
Status::options(); // ['Draft' => 'draft', 'Published' => 'published']
Status::fromName('Draft'); // Status::Draft
Status::Draft->is(Status::Published); // false
Status::Draft->description(); // 'Draft'

EnumHelper::valueMap(Status::class); // ['draft' => Status::Draft, 'published' => Status::Published]
```

## State Machines

For workflow-like enums, use [`StateMachine\HasTransitions`](src/StateMachine/HasTransitions.php).

```php
<?php

declare(strict_types=1);

use FastForward\Enum\StateMachine\HasTransitions;
use FastForward\Enum\StateMachine\InvalidTransitionException;

enum ArticleWorkflow: string
{
    use HasTransitions;

    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Archived = 'archived';

    protected static function transitionMap(): array
    {
        return [
            self::Draft->name => [self::Reviewing, self::Archived],
            self::Reviewing->name => [self::Published, self::Draft],
            self::Published->name => [self::Archived],
            self::Archived->name => [],
        ];
    }

    protected static function initialStateCases(): array
    {
        return [self::Draft];
    }
}

ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Reviewing); // true
ArticleWorkflow::Archived->isTerminal(); // true
ArticleWorkflow::initialStates(); // [ArticleWorkflow::Draft]

try {
    ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Archived);
} catch (InvalidTransitionException $exception) {
    // Invalid transition
}
```

## Labels

If your enum exposes a presentation label, implement [`LabeledEnumInterface`](src/LabeledEnumInterface.php).

```php
<?php

declare(strict_types=1);

use FastForward\Enum\Helper\EnumHelper;
use FastForward\Enum\LabeledEnumInterface;

enum Priority: int implements LabeledEnumInterface
{
    case Low = 1;
    case High = 2;

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low priority',
            self::High => 'High priority',
        };
    }
}

EnumHelper::labels(Priority::class); // ['Low priority', 'High priority']
EnumHelper::labelMap(Priority::class); // ['Low' => 'Low priority', 'High' => 'High priority']
```

## Common Enums

The package also ships with a few reusable enums for cross-project concerns.

```php
<?php

declare(strict_types=1);

use FastForward\Enum\Common\Environment;
use FastForward\Enum\Common\Month;
use FastForward\Enum\Common\Priority;
use FastForward\Enum\Common\Severity;
use FastForward\Enum\Common\Weekday;

Environment::Production->isProduction(); // true
Environment::Testing->isDebugFriendly(); // true

Priority::Critical->isHigherThan(Priority::Normal); // true
Priority::ordered(); // [Low, Normal, High, Critical]

Severity::Error->isAtLeast(Severity::Warning); // true
Weekday::Saturday->isWeekend(); // true
Month::December->quarter(); // 4
```

## Design Notes

- No `Contracts` bucket. The optional interface lives in the root namespace with the rest of the public API.
- No framework dependency.
- No attribute or reflection-heavy abstractions in v1.
- `fromName()` mirrors the engine style and throws `ValueError` for invalid case names.

## License

MIT © 2026 [Felipe Sayão Lobato Abreu](https://github.com/mentordosnerds)
