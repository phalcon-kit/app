# Changelog

All notable changes to the Phalcon Kit App skeleton are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and releases follow [Semantic Versioning](https://semver.org/).

## [2.0.0] - 2026-08-20

App 2.0.0 establishes a modern project layout and intentionally changes the
supported entrypoint and application configuration contracts from App 1.x.

### Changed

- Require PHP 8.5, Phalcon 5.19, and Phalcon Kit Core 3.10.1.
- Move Composer-autoloaded application classes from `app/` to `src/` and
  simplify the root configuration class from `App\Config\Config` to
  `App\Config` at `src/Config.php`.
- Keep application runtime entrypoints in `bin/` and move migrations,
  scaffolding, and maintainer helpers to `scripts/`.
- Replace the legacy Phalcon DevTools wrappers with `phalcon/migrations` 3.
- Make web, CLI, test, and devtool entrypoints independent of the current
  working directory.
- Replace the legacy Apache boilerplate with a minimal public-root router and
  conservative security headers.
- Commit the Composer lockfile for reproducible project creation.
- Stop granting anonymous access to the Admin module example; applications can
  add role-specific Admin permissions deliberately.

### Added

- App-owned Composer QA scripts for validation, audit, PHPCS, PHPStan, and
  PHPUnit.
- A documented `.env.example`, modern repository documentation, GitHub CI,
  Dependabot configuration, and security policy.
- Cross-platform model generation and regeneration helpers.
- Safe scaffold defaults that preserve concrete models, skip application-owned
  controllers and tests, and use an app-owned abstract model extension point.
- An App 1.x to 2.0 upgrade guide for the breaking project-layout changes.
- An optional WebSocket module and `bin/websocket` entrypoint with a safe
  ping/pong protocol, loopback defaults, Swoole configuration, and tests.
- Development-only Swoole 6.2 IDE stubs so WebSocket code remains analyzable
  without requiring the extension for ordinary installs.

### Fixed

- Prevent bootstrap and Composer autoloader files from being included more than
  once in the same process.

### Removed

- Legacy root CLI, loader, web, and empty directory placeholder entrypoints.
- Unrestricted Apache CORS headers and unconditional HTTPS/domain redirects.
- Development stability and unused Composer plugin configuration.

## [1.0.0] - 2025-07-09

- Published the legacy application skeleton.

[2.0.0]: https://github.com/phalcon-kit/app/compare/1.0.0...2.0.0
[1.0.0]: https://github.com/phalcon-kit/app/releases/tag/1.0.0
