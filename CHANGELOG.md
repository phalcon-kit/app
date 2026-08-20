# Changelog

All notable changes to the Phalcon Kit App skeleton are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and releases follow [Semantic Versioning](https://semver.org/).

## [Unreleased]

This release is planned as App 2.0.0 because the project layout and supported
entrypoint paths change incompatibly from App 1.x.

### Changed

- Require PHP 8.5, Phalcon 5.19, and Phalcon Kit Core 3.10.
- Move Composer-autoloaded application classes from `app/` to `src/` while
  retaining the `App\Config\Config` class contract.
- Keep application runtime entrypoints in `bin/` and move migrations,
  scaffolding, and maintainer helpers to `scripts/`.
- Replace the legacy Phalcon DevTools wrappers with `phalcon/migrations` 3.
- Make web, CLI, test, and devtool entrypoints independent of the current
  working directory.
- Replace the legacy Apache boilerplate with a minimal public-root router and
  conservative security headers.
- Commit the Composer lockfile for reproducible project creation.

### Added

- App-owned Composer QA scripts for validation, audit, PHPCS, PHPStan, and
  PHPUnit.
- A documented `.env.example`, modern repository documentation, GitHub CI,
  Dependabot configuration, and security policy.
- Cross-platform model generation and regeneration helpers.
- Safe scaffold defaults that preserve concrete models, skip application-owned
  controllers and tests, and use an app-owned abstract model extension point.
- An App 1.x to 2.0 upgrade guide for the breaking project-layout changes.

### Fixed

- Prevent bootstrap and Composer autoloader files from being included more than
  once in the same process.

### Removed

- Legacy root CLI, loader, web, and empty directory placeholder entrypoints.
- Unrestricted Apache CORS headers and unconditional HTTPS/domain redirects.
- Development stability and unused Composer plugin configuration.

## [1.0.0] - 2025-07-09

- Published the legacy application skeleton.

[Unreleased]: https://github.com/phalcon-kit/app/compare/1.0.0...HEAD
[1.0.0]: https://github.com/phalcon-kit/app/releases/tag/1.0.0
