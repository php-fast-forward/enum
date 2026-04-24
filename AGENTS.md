# AGENTS.md

## Overview

`fast-forward/enum` is a standalone PHP 8.3+ library for enum ergonomics and reusable enum catalogs in the Fast Forward ecosystem.

The public surface is centered on:

- `src/Trait/` for reusable enum traits such as `HasValues`, `HasNames`, `HasLabel`, `HasDescription`, and `Comparable`
- `src/Helper/EnumHelper.php` for generic static helpers over `UnitEnum` and `BackedEnum`
- root public interfaces such as `LabeledEnumInterface`, `DescribedEnumInterface`, and `ReversibleInterface`
- focused domain namespaces such as `Calendar/`, `Common/`, `Sort/`, `Logger/`, `Runtime/`, `DateTime/`, `Comparison/`, `Outcome/`, `Http/`, `Process/`, `Event/`, `Container/`, and `Pipeline/`
- `src/StateMachine/` for enum-based workflow transitions

Keep new public API small, explicit, and framework-agnostic. Avoid vague “bucket” namespaces when a more specific domain namespace fits.

## Setup

Install dependencies with:

```bash
composer install
```

This package uses `fast-forward/dev-tools` as a dev dependency and inherits its test and repo-maintenance workflows.

## Reliable Commands

Use these commands for minimum local validation:

```bash
./vendor/bin/dev-tools tests
composer dump-autoload
```

The PHPUnit config comes from `vendor/fast-forward/dev-tools/phpunit.xml`, so do not recreate a local `phpunit.xml.dist` unless there is a very strong reason.

Use broader checks when the change touches those surfaces:

```bash
./vendor/bin/dev-tools standards
./vendor/bin/dev-tools phpdoc
./vendor/bin/dev-tools docs
./vendor/bin/dev-tools dependencies
./vendor/bin/dev-tools changelog:check
```

Use `./vendor/bin/dev-tools wiki` only when wiki output or wiki-related docs need to be regenerated.

## Current Tooling Caveats

The current `dev-tools` version in this repo has known issues:

- `./vendor/bin/dev-tools --fix` completes, but may emit noisy Composer plugin errors related to Symfony Console command discovery.
- `composer agents` is not a reliable entrypoint in this checkout; prefer `./vendor/bin/dev-tools agents` and `./vendor/bin/dev-tools skills` when synchronizing those assets.
- `./vendor/bin/dev-tools dev-tools:sync --overwrite --no-interaction` can fail when copying Git hooks into `.git/hooks` because of permissions.

If you need to format or refactor code, prefer small, targeted edits and re-run the test commands above.

## Project Agents

Packaged project-agent prompts live in `.agents/agents/`. They are synchronized from `fast-forward/dev-tools` as relative symlinks into `vendor/`, so they are expected to resolve after `composer install`. Do not replace those links with absolute paths or local copies unless the task explicitly requires changing the packaging model.

Available agents:

- `agents-maintainer` keeps `AGENTS.md` aligned with the current repository workflows, packaged skills, and agent surface.
- `docs-writer` maintains the Sphinx documentation tree under `docs/`.
- `readme-maintainer` keeps `README.md` aligned with the public package surface, install flow, badges, links, and onboarding examples.
- `test-guardian` audits and extends PHPUnit coverage.
- `php-style-curator` normalizes PHP headers, PHPDoc, imports, and style without changing behavior.
- `quality-pipeline-auditor` checks test, style, docs, CI, and generated-output risk across the quality pipeline.
- `review-guardian` performs findings-first review passes for bugs, regressions, missing docs, missing tests, and workflow risk.
- `consumer-sync-auditor` reviews downstream impact for synchronized DevTools assets, workflow wrappers, wiki/bootstrap files, packaged agents, and packaged skills.
- `changelog-maintainer` maintains Keep a Changelog entries and release-note material.
- `issue-editor` turns rough maintenance, bug, or feature requests into implementation-ready GitHub issues.
- `issue-implementer` carries ready issues through implementation, verification, and PR publication.

When delegating, read the matching prompt in `.agents/agents/<agent>.md` and keep the assignment narrow. Agent prompts define role boundaries; procedural steps still come from `.agents/skills/`.

## Repository Layout

Important paths:

- `src/` main library code
- `tests/` PHPUnit suite
- `tests/Support/` enum fixtures used across tests
- `README.md` package onboarding and usage examples
- `docs/` Sphinx documentation for installation, quickstart, usage, API references, and advanced integration notes
- `.github/wiki/` generated wiki content used by wiki workflows
- `.agents/agents/` packaged role prompts for repository-specific delegation
- `.agents/skills/` procedural skills used by the packaged agents
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
- `docs/`
- `CHANGELOG.md` once release tracking is initialized
- tests with real usage examples

Prefer onboarding-friendly examples for new users. Show practical enum calls instead of only listing cases.

Use `README.md` as the canonical short-form package guide and expand from there into Sphinx docs rather than duplicating content blindly. For new-user documentation, explain what each helper or enum catalog solves, then show the smallest useful example.

When wiki output is part of the task, update `.github/wiki/` through the supported `dev-tools` wiki command instead of hand-editing generated pages.

## Collaboration Notes

This repository may already contain uncommitted work. Check `git status` before editing and do not revert unrelated changes.

When changing public API:

- preserve the package’s framework-agnostic posture
- keep naming coherent across namespaces
- update tests and README in the same pass

When opening repo-maintenance issues against `dev-tools`, prefer separate issues per bug instead of mixing unrelated failures into one report.
