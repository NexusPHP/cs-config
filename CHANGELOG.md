# Changelog

All notable changes to this library will be documented in this file:

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v2.1.0](https://github.com/NexusPHP/cs-config/compare/v2.0.2..v2.0.2) - 2020-12-08

### Added

- Added support for new fixers in [v2.17.0 Desert Beast](https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/tag/v2.17.0).
- Added `Nexus74` ruleset for support on `use_arrow_functions` fixer.
- Added testing for deprecated fixers.

### Changed

- `phpdoc_line_span` has been set to single for all classy elements.
- `binary_operator_spaces` has been set to its default `single_space` for use in this library.

## [v2.0.2](https://github.com/NexusPHP/cs-config/compare/v2.0.1..v2.0.2) - 2020-12-01

### Fixed

- Re-release of previous release due to inconsistency in tagging process.

## [v2.0.1](https://github.com/NexusPHP/cs-config/compare/v2.0.0..v2.0.1) - 2020-12-01

### Changed

- `global_namespace_import` has its option `import_classes` set to `false`.
- Renamed `phpunit.xml.dist`'s `cacheResultFile` attribute

## [v2.0.0](https://github.com/NexusPHP/cs-config/releases/tag/v2.0.0) - 2020-11-28

### Changed

- Initial release in this repository. See [MIGRATION](MIGRATION.md) for the detailed changes
from its predecessor library.
