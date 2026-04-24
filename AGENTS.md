# AGENTS.md

## Overview

`fast-forward/enum` is a standalone PHP 8.3+ library for enum ergonomics and reusable enum catalogs in the Fast Forward ecosystem.

The public surface is centered on:

- `src/Trait/` for reusable enum traits such as `HasValues`, `HasNames`, and `Comparable`
- `src/Helper/EnumHelper.php` for generic static helpers over `UnitEnum` and `BackedEnum`
- focused domain namespaces such as `Calendar/`, `Sort/`, `Logger/`, `Runtime/`, `DateTime/`, `Comparison/`, `Outcome/`, `Http/`, `Process/`, `Event/`, `Container/`, and `Pipeline/`
- `src/StateMachine/` for enum-based workflow transitions

Keep new public API small, explicit, and framework-agnostic. Avoid vague “bucket” namespaces when a more specific domain namespace fits.

## Setup

Install dependencies with:

```bash
composer install
```

This package uses `fast-forward/dev-tools` as a dev dependency and inherits its test and repo-maintenance workflows.

## Reliable Commands

Use these commands for validation:

```bash
./vendor/bin/dev-tools tests
composer dump-autoload
```

The PHPUnit config comes from `vendor/fast-forward/dev-tools/phpunit.xml`, so do not recreate a local `phpunit.xml.dist` unless there is a very strong reason.

## Current Tooling Caveats

The current `dev-tools` version in this repo has known issues:

- `./vendor/bin/dev-tools --fix` completes, but may emit noisy Composer plugin errors related to Symfony Console command discovery.
- `composer agents` is currently broken through the Composer plugin path.
- `./vendor/bin/dev-tools dev-tools:sync --overwrite --no-interaction` can fail when copying Git hooks into `.git/hooks` because of permissions.
- `.agents` payload synchronization from `dev-tools` is currently unreliable, so do not assume generated agent assets exist locally.

If you need to format or refactor code, prefer small, targeted edits and re-run the test commands above.

## Repository Layout

Important paths:

- `src/` main library code
- `tests/` PHPUnit suite
- `tests/Support/` enum fixtures used across tests
- `README.md` package onboarding and usage examples
- `.github/workflows/` CI workflows managed by `dev-tools`

The current test layout is intentionally split by concern:

- `tests/Common/`
- `tests/Sort/`
- `tests/StateMachine/`
- `tests/Helper/`
- `tests/Trait/`
- `tests/Support/`
- `tests/DomainEnumTest.php` for smaller domain namespaces

When adding tests, keep them close to the namespace or feature they exercise instead of rebuilding monolithic test files.

## Code Style

Follow existing Fast Forward PHP conventions:

- keep `declare(strict_types=1);`
- preserve the repository file header block
- keep PHPDoc in English
- prefer precise namespace names over catch-all buckets
- keep interfaces in the root namespace when they are part of the public package surface
- do not introduce framework dependencies
- avoid reflection-heavy or attribute-heavy abstractions unless there is already an established pattern

For enum design:

- prefer methods that express behavior, not just metadata duplication
- avoid enums that encode framework- or PSR-specific runtime policies unless they stay useful in a raw, non-opinionated consumer
- do not call something a polyfill unless it truly mirrors native behavior and loading semantics

## Testing Expectations

For any code change:

1. run `composer dump-autoload` if files or namespaces changed
2. run `./vendor/bin/dev-tools tests`

When reorganizing namespaces, verify both autoload and test imports before finalizing.

## Documentation Expectations

Any meaningful API or namespace change should be reflected in:

- `README.md`
- tests with real usage examples

Prefer onboarding-friendly examples for new users. Show practical enum calls instead of only listing cases.

If broader docs work is requested later, use `README.md` as the canonical short-form package guide and expand from there into Sphinx docs rather than duplicating content blindly.

## Collaboration Notes

This repository may already contain uncommitted work. Check `git status` before editing and do not revert unrelated changes.

When changing public API:

- preserve the package’s framework-agnostic posture
- keep naming coherent across namespaces
- update tests and README in the same pass

When opening repo-maintenance issues against `dev-tools`, prefer separate issues per bug instead of mixing unrelated failures into one report.
