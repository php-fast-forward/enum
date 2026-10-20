---
name: fast-forward-enum
description: Integrate Fast Forward enum traits, catalogs, name/value lookups and transitions with explicit handling of invalid external values.
license: MIT; see LICENSE
compatibility: Supports fast-forward/enum ^0.2 and PHP ^8.3. Requires Composer and declared extensions; inspect the installed version. Earlier releases are outside this contract. Requires ext-mbstring.
metadata:
  author: Fast Forward
  api-baseline: fast-forward/enum ^0.2
---

# Use enum helpers and catalogs

Use this skill for an application consuming `fast-forward/enum:^0.2`.
Read its instructions, manifest/lockfile and installed source before editing.
Run `composer show fast-forward/enum`. For versions outside this contract,
inspect matching documentation; do not silently upgrade the application.

## First working integration

Requires PHP ^8.3, Composer's application autoloader and this package's runtime
dependencies. Enable ext-mbstring.
With authority to install the dependency:

```sh
composer require 'fast-forward/enum:^0.2'
```

Create `app.php` in the application root alongside composer.json/vendor:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use FastForward\Enum\Calendar\Weekday;
use FastForward\Enum\Helper\EnumHelper;

$values = EnumHelper::values(Weekday::class);
if ($values !== [1, 2, 3, 4, 5, 6, 7]
    || EnumHelper::fromName(Weekday::class, 'Monday') !== Weekday::Monday
    || EnumHelper::tryFromName(Weekday::class, 'not-a-day') !== null
    || Weekday::tryFrom(0) !== null) {
    throw new RuntimeException('Enum lookup contract differs.');
}

echo "integration ready\n";
```

Run `php app.php`. It throws on a wrong result; success prints
`integration ready`. It uses no production data and starts no server.

## Wiring and failure boundaries

Requires PHP 8.3 and ext-mbstring; no container or configuration file is needed. Composer package `fast-forward/enum` exposes `FastForward\Enum`. Use a catalog only when its values match the application's domain; otherwise define your own enum in a same-named file.

For a custom string/int backed enum use the HasValues, HasNames, HasNameLookup, HasNameMap, HasValueMap and HasOptions traits from `FastForward\Enum\Trait` as needed. HasOptions maps case names to backing values; it is not an automatically translated UI label map. HasLabel's default label contains the enum class and case name; override label() and implement LabeledEnumInterface for deliberate presentation text. EnumHelper::labels requires that interface. Unit enums have names/cases but no backed values; passing a non-enum or a unit enum to values() raises ValueError.

External strings are case-sensitive for name lookup. Use tryFromName or backed tryFrom for untrusted values, and explicitly distinguish null from a valid zero/empty backing value. The throwing alternatives signal ValueError.

For enum state workflows, implement HasTransitions::transitionMap() with case-name keys and target-case lists in the application's enum file; canTransitionTo checks membership and assertCanTransitionTo raises InvalidTransitionException. It validates a transition, but does not persist or mutate an entity. This skill supports ^0.2; the ^0.1 line is outside this skill's version contract.

## Verify integration

Run the [complete example](examples/integration.php) against the application's
autoloader in a disposable process. It checks success and negative cases:

```sh
php /path/to/fast-forward-enum/examples/integration.php ./vendor/autoload.php
```

Expected final marker: `fast-forward-enum: ok`. Keep application-specific regression
tests in its existing PHPUnit suite, with each fixture class in its same-named
file. File copying, host discovery and completed agent tasks are different checks.
For optional copying/synchronization load
[installation and lifecycle](references/installation.md).
