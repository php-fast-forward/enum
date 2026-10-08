# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- Replace the mascot banner with contextual Dash artwork for typed enum cases and align README and documentation references. (#5)

### Fixed

- Mirror verified Dependabot push test outcomes through a separate completion workflow so required statuses are available with the bot's restricted token.
- Allow the isolated CI status publisher to read workflow job outcomes without granting write permissions to test jobs.

## [0.1.0] - 2026-04-24

### Added

- Bootstrap the initial enum component with helper APIs, reusable traits, packaged enum catalogs, state-machine utilities, documentation, and repository automation.

### Fixed

- Restore catalog and domain enum coverage so CI dependency and coverage gates pass.
- Update DevTools workflow wrappers so changelog releases and wiki-triggered test validation receive the permissions and triggers required by the shared automation (#3).


[unreleased]: https://github.com/php-fast-forward/enum/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/php-fast-forward/enum/releases/tag/v0.1.0
