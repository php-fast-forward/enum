# Fast Forward Enum

Ergonomic utilities and reusable catalogs for PHP enums, including names, values, lookups, maps,
sorting helpers, and enum-driven workflows.

[![PHP Version](https://img.shields.io/badge/php-^8.3-777BB4?logo=php&logoColor=white)](https://www.php.net/releases/)
[![Composer Package](https://img.shields.io/badge/composer-fast--forward%2Fenum-F28D1A.svg?logo=composer&logoColor=white)](https://packagist.org/packages/fast-forward/enum)
[![Tests](https://img.shields.io/github/actions/workflow/status/php-fast-forward/enum/tests.yml?logo=githubactions&logoColor=white&label=tests&color=22C55E)](https://github.com/php-fast-forward/enum/actions/workflows/tests.yml)
[![Coverage](https://img.shields.io/badge/coverage-phpunit-4ADE80?logo=php&logoColor=white)](https://php-fast-forward.github.io/enum/coverage/index.html)
[![Docs](https://img.shields.io/github/deployments/php-fast-forward/enum/github-pages?logo=readthedocs&logoColor=white&label=docs&labelColor=1E293B&color=38BDF8&style=flat)](https://php-fast-forward.github.io/enum/index.html)
[![License](https://img.shields.io/github/license/php-fast-forward/enum?color=64748B)](LICENSE)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/php-fast-forward?logo=githubsponsors&logoColor=white&color=EC4899)](https://github.com/sponsors/php-fast-forward)

![Fast Forward Enum mascot banner](docs/_static/enum-mascot-banner.png)

## ✨ Features

- 🧩 Traits for `values()`, `names()`, options, maps, lookups, and enum comparisons
- 🧭 `Helper\EnumHelper` for generic operations over `UnitEnum` and `BackedEnum`
- 🔄 Reversible sort-oriented enums such as `SortDirection`, `NullsPosition`, and `ComparisonResult`
- 🗂 Reusable catalogs grouped by domain, including `Calendar`, `Logger`, `Runtime`, and `DateTime`
- 🚦 Enum-based workflow transitions through `StateMachine\HasTransitions`
- 🏷 Optional `LabeledEnumInterface` and readable descriptions without framework lock-in
- 🧼 Small public API with explicit namespaces and no `Contracts` bucket

## 📦 Installation

```bash
composer require fast-forward/enum
```

Requirements:

- PHP `^8.3`

New to the package? Start with the [Quickstart](docs/getting-started/quickstart.rst), then use the
[Usage guide](docs/usage/index.rst) when you want more complete examples.

## 🛠️ Usage

Basic enum ergonomics:

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

Labels and label maps:

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

Enum-driven workflows:

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

Packaged enum catalogs:

```php
<?php

declare(strict_types=1);

use FastForward\Enum\Calendar\Month;
use FastForward\Enum\Calendar\Quarter;
use FastForward\Enum\Calendar\Semester;
use FastForward\Enum\Calendar\Weekday;
use FastForward\Enum\Common\Priority;
use FastForward\Enum\Common\Severity;
use FastForward\Enum\Comparison\ComparisonOperator;
use FastForward\Enum\Container\ServiceLifetime;
use FastForward\Enum\DateTime\IntervalUnit;
use FastForward\Enum\Event\DispatchMode;
use FastForward\Enum\Http\Scheme;
use FastForward\Enum\Logger\LogLevel;
use FastForward\Enum\Outcome\Result;
use FastForward\Enum\Pipeline\FailureMode;
use FastForward\Enum\Process\SignalBehavior;
use FastForward\Enum\Runtime\Environment;
use FastForward\Enum\Sort\CaseSensitivity;
use FastForward\Enum\Sort\ComparisonResult;
use FastForward\Enum\Sort\NullsPosition;
use FastForward\Enum\Sort\SortDirection;

Environment::Production->isProduction(); // true
Priority::Critical->isHigherThan(Priority::Normal); // true
Severity::Error->isAtLeast(Severity::Warning); // true
LogLevel::Critical->isAtLeast(LogLevel::Warning); // true
Result::Partial->isSuccessful(); // true
ComparisonOperator::In->compare('draft', ['draft', 'published']); // true
IntervalUnit::Hour->seconds(2); // 7200
DispatchMode::Async->isAsync(); // true
ServiceLifetime::Singleton->isReusable(); // true
FailureMode::StopOnFailure->stopsOnFailure(); // true
Scheme::Https->defaultPort(); // 443
SignalBehavior::Handle->isTerminalControl(); // true
Weekday::Saturday->isWeekend(); // true
Month::December->quarter(); // 4
Quarter::Q2->months(); // [Month::April, Month::May, Month::June]
Semester::H2->quarters(); // [Quarter::Q3, Quarter::Q4]
SortDirection::Descending->reverse(); // SortDirection::Ascending
NullsPosition::Last->compareNullability(null, 'value'); // 1
CaseSensitivity::Insensitive->equals('Draft', 'draft'); // true
ComparisonResult::fromComparisonResult(-1); // ComparisonResult::RightGreater
```

## 🧰 API Summary

| API | Description |
| --- | --- |
| `Helper\EnumHelper` | Static helpers for cases, names, values, labels, maps, and lookups |
| `Trait\HasValues` | Adds `values()` to backed enums |
| `Trait\HasNames` | Adds `names()` to any enum |
| `Trait\HasNameLookup` | Adds `fromName()`, `tryFromName()`, and `hasName()` |
| `Trait\HasOptions` | Builds option arrays keyed by case name |
| `Trait\HasNameMap` / `Trait\HasValueMap` | Builds lookup maps for names and backed values |
| `Trait\Comparable` | Adds `is()`, `isNot()`, `in()`, and `notIn()` |
| `Trait\HasDescription` | Generates readable descriptions from case names |
| `Trait\HasLabel` | Provides a technical fallback `label()` implementation |
| `LabeledEnumInterface` | Contract for enums that expose presentation labels |
| `DescribedEnumInterface` | Contract for enums that expose human-readable descriptions |
| `ReversibleInterface` | Common contract for enums exposing `reverse()` |
| `StateMachine\HasTransitions` | Adds transition, terminal, and initial-state behavior to workflow enums |
| `StateMachine\InvalidTransitionException` | Exception thrown by invalid workflow transitions |

## 🔌 Integration

`fast-forward/enum` is framework-agnostic and works well in:

- form and UI option generation
- DTO, request, and serializer layers
- validation and name/value normalization
- internal workflow modeling with enum transitions
- logging, sorting, date/time, and runtime catalogs shared across Fast Forward packages

It does not require a container, framework bridge, or reflection-heavy metadata system.

## 📁 Directory Structure Example

```text
src/
├── Calendar/
├── Common/
├── Comparison/
├── Container/
├── DateTime/
├── Event/
├── Helper/
├── Http/
├── Logger/
├── Outcome/
├── Pipeline/
├── Process/
├── Runtime/
├── Sort/
├── StateMachine/
└── Trait/
tests/
├── Common/
├── Helper/
├── Sort/
├── StateMachine/
├── Support/
└── Trait/
docs/
├── getting-started/
├── usage/
├── api/
└── advanced/
```

## ⚙️ Advanced & Customization

- Implement `LabeledEnumInterface` when you need explicit presentation labels.
- Use your own domain enums when semantics are business-specific rather than generic.
- Combine `Comparable`, lookup traits, and `HasTransitions` to build compact workflow models.
- Prefer the packaged catalogs only when the semantics are stable and cross-project.

## 🛠️ Versioning & Breaking Changes

The current development line tracks `1.x-dev`. There is no published breaking-change history yet for
this package.

## ❓ FAQ

**Q: Why does this package expose traits instead of one giant helper class?**  
Traits let enums opt into only the ergonomics they need while keeping the public surface explicit.

**Q: Why is there no `Contracts` namespace?**  
Public interfaces stay in the root namespace so the package does not hide core API behind a generic
bucket.

**Q: Is `ComparisonResult` a PHP polyfill?**  
No. It is a Fast Forward enum for comparator-style semantics, not a promise of native compatibility.

## 🛡 License

MIT © 2026 [Felipe Sayão Lobato Abreu](https://github.com/mentordosnerds)

## 🤝 Contributing

Issues, pull requests, and documentation improvements are welcome.

- Read [AGENTS.md](AGENTS.md) for repository-specific guidance
- Run `composer dump-autoload`
- Run `./vendor/bin/dev-tools tests`
- Update the [README](README.md) and relevant docs when changing public API

## 🔗 Links

- [Repository](https://github.com/php-fast-forward/enum)
- [Packagist](https://packagist.org/packages/fast-forward/enum)
- [Documentation site](https://php-fast-forward.github.io/enum/index.html)
- [Sphinx docs source](docs/index.rst)
- [Wiki](https://github.com/php-fast-forward/enum/wiki)
- [Issue tracker](https://github.com/php-fast-forward/enum/issues)
- [Coverage report](https://php-fast-forward.github.io/enum/coverage/index.html)
- [Tests workflow](https://github.com/php-fast-forward/enum/actions/workflows/tests.yml)
- [MIT License](LICENSE)
- [RFC 2119](https://datatracker.ietf.org/doc/html/rfc2119)
