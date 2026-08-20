# PhalconKit App Agent Guide

This repository is the consumer-facing project skeleton for Phalcon Kit. Keep
it small, secure by default, and usable immediately after `composer
create-project`.

## Structure

- Application classes live in `src/` under the `App\` namespace.
- `src/Config.php` owns modules, providers, model aliases, and permissions.
- `bin/` contains application runtime entrypoints only, including the CLI and
  optional WebSocket worker.
- `src/Modules/Ws/` contains the optional Swoole-backed WebSocket module and
  tasks. Keep its public example protocol narrow and require explicit
  authentication/authorization before adding subscriptions or broadcasts.
- `scripts/` contains migration, generation, and maintainer helpers; keep Unix
  and PowerShell behavior aligned.
- `public/` is the only supported web document root.
- Runtime state belongs in `storage/`; secrets belong in the untracked `.env`.

## Working Rules

- Start with `git status --short` and preserve unrelated changes.
- Prefer Composer autoloading and paths derived from `__DIR__`; commands must
  not depend on the caller's working directory.
- Keep public defaults conservative. Do not enable wildcard CORS, development
  debugging, or credential-bearing examples by default.
- Update `README.md` and `CHANGELOG.md` for consumer-visible changes.
- Update Core guides when changing the canonical application layout.
- Commit `composer.lock`; this repository is an application project.

## Validation

- `composer qa` for the full gate.
- `composer phpunit` for application behavior.
- `composer phpstan` for static analysis.
- `composer phpcs` for coding standards.
- Verify `./bin/phalcon-kit --help` from the repository and from another current
  directory after changing entrypoints.
- Verify `./bin/websocket` fails clearly when Swoole is unavailable; do not
  start a persistent listener during the normal unit-test gate.
- Verify Linux and PowerShell script paths together when helpers change.
