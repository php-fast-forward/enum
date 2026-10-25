# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.2] - 2026-10-25

### Changed

- Synchronize the bundled local skill automatically and trust Fast Forward Composer
  skill donors through `fast-forward/*`.
  Resolve Changelog contributor skills from stable `0.4.x` releases without a
  redundant skill allowlist.
  Load the project autoloader for PHPDoc checks when DevTools is installed as a
  dependency.

  ([#16](https://github.com/php-fast-forward/enum/pull/16))

## [0.2.1] - 2026-10-24

### Changed

- GitHub Actions(deps): bump php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml from c637e7f9d8ae6059b8655996e56f6d17f874792c to 2d98b607bf832a82035ddcae3d689aef72842111

  Update dependencies: `php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml`.

  ([#14](https://github.com/php-fast-forward/enum/pull/14), @dependabot[bot])

## [0.2.0] - 2026-10-20

### Added

- Bundle the fast-forward-enum consumer skill with executable examples, optional installation guidance and Composer discovery metadata. ([#12](https://github.com/php-fast-forward/enum/pull/12))

### Changed

- Restore the Changelog contributor skill through the development-only Composer skill manager and its reviewed GitHub source instead of versioning generated skill copies. ([#11](https://github.com/php-fast-forward/enum/pull/11))

### Fixed

- Use the published Changelog v0 workflow channel, identify the package and version transition in release PR titles, and remove obsolete automatic conflict resolution now that pending changes use independent fragments. ([#11](https://github.com/php-fast-forward/enum/pull/11))

## [0.1.1] - 2026-10-20

### Changed

- Adopt Fast Forward Changelog automation and its project skill for validated contribution notes and reviewed version pull requests. ([#9](https://github.com/php-fast-forward/enum/pull/9))
- Replace the mascot banner with contextual Dash artwork for typed enum cases and align README and documentation references. ([#5](https://github.com/php-fast-forward/enum/pull/5))
- Publish generated Wiki pages directly without tracking the Wiki as a Git submodule. ([#9](https://github.com/php-fast-forward/enum/pull/9))

### Fixed

- Allow the isolated CI status publisher to read workflow job outcomes without granting write permissions to test jobs. ([#9](https://github.com/php-fast-forward/enum/pull/9))
- Mirror verified Dependabot push test outcomes through a separate completion workflow so required statuses are available with the bot's restricted token. ([#9](https://github.com/php-fast-forward/enum/pull/9))
- Pin Wiki publication to the merged DevTools workflow so a squash merge cannot invalidate its source revision. ([#8](https://github.com/php-fast-forward/enum/pull/8))

## [0.1.0] - 2026-04-24

### Added

- Bootstrap the initial enum component with helper APIs, reusable traits, packaged enum catalogs, state-machine utilities, documentation, and repository automation.

### Fixed

- Restore catalog and domain enum coverage so CI dependency and coverage gates pass.
- Update DevTools workflow wrappers so changelog releases and wiki-triggered test validation receive the permissions and triggers required by the shared automation (#3).


[0.2.2]: https://github.com/php-fast-forward/enum/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/php-fast-forward/enum/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/php-fast-forward/enum/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/php-fast-forward/enum/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/php-fast-forward/enum/releases/tag/v0.1.0
