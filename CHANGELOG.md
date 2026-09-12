# Changelog

All notable changes to the Phalcon Kit App skeleton are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and releases follow [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Security

- Make `.env.example` explicitly deny cross-origin access and disable debug
  output. Add a required private JWT signing-key setting without shipping a
  shared secret, and document generation, persistence, rotation, and explicit
  credentialed CORS origin allowlists.
- Add a separate private encryption-key setting and document the new Core key
  format, existing-ciphertext migration, password-reset hooks, and OAuth state
  upgrade requirements. The new key format requires the forthcoming Core update.
- Companion to Core's unreleased security fixes. Before publishing this App
  release, release the fixed Core package, raise the Core requirement, update
  the committed lockfile, and rerun App QA and public create-project validation.
  App 2.0.5 / Core 3.10.6 do not contain the new Core fixes.

## [2.0.5] - 2026-09-11

### Fixed

- Require Phalcon Kit Core `^3.10.6` and update the committed lockfile to
  Core 3.10.6 so new projects inherit JWT validation enforcement and generic
  unauthorized responses before identity lookup or refresh-token issuance.

### Changed

- Document JWT upgrade behavior and the independent App and Core version
  numbers, including how the dependency constraint and lockfile select Core.

## [2.0.4] - 2026-08-28

### Changed

- Raised the application runtime, matching IDE-stub, and checksum-verified CI
  baselines to Phalcon 5.20.3 so new projects receive its ACL, authentication,
  storage, event-cancellation, routing, validation, and parser hardening.
- Require Phalcon Kit Core 3.10.5 for its Phalcon 5.20.3 runtime floor,
  compatibility coverage, cache deserialization policy, and final
  `rest:beforeSave` denial behavior.
- Updated the checkout and PHP setup actions to immutable, Node.js
  24-compatible releases for warning-free CI execution.

## [2.0.3] - 2026-08-26

### Changed

- Raised the application runtime and CI baseline to Phalcon 5.20.2 with Zephir
  1.3.0, using its native literal-route index fix. The latest official 5.20.1
  IDE stubs remain compatible because Phalcon 5.20.2 changes no public API.
- Require Phalcon Kit Core 3.10.4 for its Phalcon 5.20.2 runtime floor and
  removal of the superseded Router notice workaround.
- Aligned PHPUnit with Phalcon 5.20.2's stricter test posture by failing on
  notices, deprecations, and PHPUnit deprecations and printing each trigger.

## [2.0.2] - 2026-08-25

### Fixed

- Require Phalcon Kit Core 3.10.3 so the runtime version reports the correct
  Core release number.

## [2.0.1] - 2026-08-25

### Changed

- Raised the application, IDE-stub, and CI baseline to Phalcon 5.20.1 so new
  projects start on the framework's security-hardened release.
- Require Phalcon Kit Core 3.10.2 for its Phalcon 5.20.1 compatibility coverage
  and narrowly scoped Router notice workaround.

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

[Unreleased]: https://github.com/phalcon-kit/app/compare/2.0.5...HEAD
[2.0.5]: https://github.com/phalcon-kit/app/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/phalcon-kit/app/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/phalcon-kit/app/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/phalcon-kit/app/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/phalcon-kit/app/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/phalcon-kit/app/compare/1.0.0...2.0.0
[1.0.0]: https://github.com/phalcon-kit/app/releases/tag/1.0.0
