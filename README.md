# Phalcon Kit App

`master` prepares **App 4.0.0 with Core 4.0.0**. App intentionally skips 3.x to
align with Core. Both packages are still unreleased; use this branch for
isolated evaluation. Only 4.x is maintained, and all earlier versions are
unsupported. See [UPGRADE.md](UPGRADE.md) for migration and release requirements.

[![CI](https://github.com/phalcon-kit/app/actions/workflows/ci.yml/badge.svg)](https://github.com/phalcon-kit/app/actions/workflows/ci.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/phalcon-kit/app)](https://packagist.org/packages/phalcon-kit/app)
[![PHP](https://img.shields.io/packagist/dependency-v/phalcon-kit/app/php)](https://packagist.org/packages/phalcon-kit/app)
[![Downloads](https://img.shields.io/packagist/dt/phalcon-kit/app)](https://packagist.org/packages/phalcon-kit/app)
[![License](https://img.shields.io/packagist/l/phalcon-kit/app)](LICENSE)

Start a modern Phalcon application with Phalcon Kit's HTTP, CLI, and optional
WebSocket runtimes, permissions, database scaffolding, and production-oriented
project layout already connected.

The reference skeleton keeps each module thin. Application code belongs to
your project; the reusable framework behavior stays in
[`phalcon-kit/core`](https://github.com/phalcon-kit/core).

## Requirements

- PHP 8.5 or newer
- Phalcon 5.22.0 or newer on the 5.x release line
- Composer 2
- A PDO-compatible database for model-backed features
- Optional: Swoole 6.2 for the WebSocket server

MySQL 8 is the primary migration and scaffolding baseline, but PhalconKit can
use other PDO adapters supported by Phalcon.

See the official
[Phalcon installation guide](https://docs.phalcon.io/latest/installation/) for
extension installation instructions.

## Create A Project

```shell
composer create-project phalcon-kit/app:dev-master my-app
cd my-app
cp .env.example .env
composer qa
```

This installs the development preview with its committed Core 4 lockfile. The
stable installation command will use `phalcon-kit/app:^4.0` after both 4.0.0
tags are published and verified.

Update `.env` for the application and database before enabling model-backed
services. Do not commit `.env` or production credentials.

Before using authentication, generate a signing key with
`php -r 'echo bin2hex(random_bytes(64)), PHP_EOL;'` and store it as
`SECURITY_JWT_PASSPHRASE` in the untracked `.env` or your deployment secret
store. Generate it once per environment and share it only among that
environment's application instances. Keep it stable across restarts. Replacing
it invalidates existing access and refresh tokens and requires users to sign in
again. Never reuse a key from framework source or documentation.

Before using encryption, configure a separate private `CRYPT_KEY`. For new
data, generate it with:

```shell
php -r 'echo "base64:", base64_encode(random_bytes(32)), PHP_EOL;'
```

The new Core provider decodes that prefix into 32 random key bytes; existing
unprefixed raw keys keep their bytes. Do not change a key, cipher, signing mode,
or `CRYPT_AUTH_DATA` when stored ciphertext already exists without a reviewed
migration. The shared legacy encryption key is rejected by the hardened Core
provider retained in Core 4.

The example environment disables debug output and cross-origin access. For a
browser frontend on another origin, set
`RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_ORIGIN=https://your-frontend.example`
(use a comma-separated list for multiple origins). Enable
`RESPONSE_HEADER_ACCESS_CONTROL_ALLOW_CREDENTIALS=true` only when those trusted
origins need browser cookies or other browser-managed credentials. Wildcard
origins are suitable only for public, non-credentialed access. Set
`APP_DEBUG=true` only in private local development.

For local development with PHP's built-in server:

```shell
php -S 127.0.0.1:8080 -t public public/index.php
```

For Apache, Nginx, Caddy, containers, or a platform proxy, configure `public/`
as the document root. Never expose the repository root as the web root.

## Versions And Framework Updates

App and Core start the 4.x line together at **4.0.0**. App versions describe the
project skeleton; Core versions describe the framework API. App 4.0.0 will require
Core `^4.0`, with the committed `composer.lock` selecting the tested stable
release installed when creating a project. During preparation, `^4.0@dev`
explicitly allows Core's `4.0.x-dev` branch alias. Other dependencies retain
Composer's default stable selection.

### Upgrading To Core 4.0 And Phalcon 5.22

Upgrade the native Phalcon extension in CLI, PHP-FPM, and worker environments,
then run `composer check-platform-reqs` and `composer qa`. Review the
[Core 4.0 upgrade guide](https://github.com/phalcon-kit/core/blob/master/guides/upgrading-4.0.md)
for retired catalog/CMS models, API routes, providers, and permission presets.
Application-owned models and schemas need their own upgrade checks. See the
[runtime upgrade guide](https://phalcon-kit.github.io/docs/guides/phalcon-runtime-upgrades/)
for native Phalcon compatibility changes.

Core 4 retains the authentication protections from the previous releases. Invalid
credentials now produce HTTP 401 before identity lookup or refresh-token
issuance. Refresh requests should send `refreshToken` without an
expired access token, and login requests should omit stale invalid JWTs.

Existing projects should update their Core dependency and commit the resulting
lockfile. They do not need to recreate the project from this skeleton. Read the
[Core JWT upgrade guidance](https://phalcon-kit.github.io/docs/guides/identity-and-permissions/#jwt-validation-and-upgrades)
for custom identity and error-controller considerations.

Core also expires and atomically consumes password
reset records, hashes new passwords, and enforces expiring, single-use OAuth2
state before code exchange. Review custom model hashing and reset-delivery
hooks; old pending reset links and OAuth logins must restart. Session revocation
remains application policy. The Core
[security upgrade guide](https://github.com/phalcon-kit/core/blob/master/guides/security-hardening.md)
describes the migration and validation requirements. Default PHP-session
identity storage renews its session ID on authenticated identity changes,
including refresh; clients must accept the updated cookie. Custom persistence
overrides must invalidate identity/ACL caches and own equivalent fixation
protection. Token lifetimes and idle/absolute session policies are unchanged.

## Project Layout

```text
src/
  Bootstrap.php         Application bootstrap
  Config.php            Modules, providers, aliases, and permissions
  Models/               Application and generated models
  Modules/
    Admin/               Admin controllers
    Api/                 REST API controllers
    Cli/                 CLI tasks
    Frontend/            Browser-facing controllers
    Ws/                  Optional WebSocket tasks
bin/                    CLI and WebSocket runtime entrypoints
public/                 Web document root
resources/migrations/  Database migrations
scripts/                Migration, scaffolding, and maintainer helpers
storage/                Cache, logs, files, backups, and runtime data
tests/Unit/             Application tests
bootstrap.php           Paths and Composer autoloading
```

`App\` is PSR-4 autoloaded from `src/`. Environment-specific values belong in
`.env`; structural application policy belongs in `src/Config.php`.

Frontend and API index actions are public examples. The Admin module is
registered as an extension point but has no anonymous permission by default;
grant its controllers only to application roles that require them.

## CLI

The project CLI loads `App\Bootstrap`, so project modules and tasks are
available alongside the tasks supplied by Core:

```shell
./bin/phalcon-kit --help
./bin/phalcon-kit cli cron run
```

The launcher resolves the project root from its own path, so it can be invoked
from any working directory. Windows users can run `bin\phalcon-kit.bat`.

## WebSocket

The optional WebSocket example accepts only `{"type":"ping"}` and answers
with `{"type":"pong"}`. It does not expose anonymous subscription or
broadcast behavior.

Install Swoole in the PHP runtime that will own the long-running worker, then
start it with:

```shell
./bin/websocket
```

The default listener is `127.0.0.1:8081`. Override the commented
`SWOOLE_*` values in `.env` when necessary. Keep loopback binding when Apache,
Nginx, Caddy, or another trusted proxy terminates TLS; containers can bind to
`0.0.0.0` on an isolated network.

The committed `swoole/ide-helper` package is development-only and does not
install the extension. Production should run the worker under a supervisor and
proxy a dedicated path such as `/ws/` to it. See
[Web Server And WebSocket](https://phalcon-kit.github.io/docs/guides/web-server-and-websocket/)
for proxy, container, systemd, and operational guidance.

## Migrations And Models

Application migrations live in `resources/migrations/`. Core 4 no longer supplies
implicit maintenance table lists or seed accounts. Define any maintenance lists
and seed rows explicitly in `src/Config.php` under `deployment`; see the
[Core maintenance contract](https://github.com/phalcon-kit/core/blob/master/guides/upgrading-4.0.md#explicit-database-maintenance).

Core-backed features need their tables. For a **fresh database** and an empty
application migration tree, adopt the Core 4 baseline explicitly:

```shell
mkdir -p resources/migrations
cp -R vendor/phalcon-kit/core/resources/migrations/4.0.0 resources/migrations/
./scripts/migration-list.sh
./scripts/migration-run.sh
```

It creates 29 retained Core tables, plus migration history, using InnoDB and
connection-local foreign keys. It has no seed accounts or retired catalog/CMS
tables. Existing schemas/history are rejected; keep existing application data
and write separate upgrade migrations. Applied migrations belong to the app and
must remain immutable.

For your own SQL migrations, extend `PhalconKit\Migrations\SqlMigration` and
call `executeSqlFile(__DIR__ . '/sql/create-products.sql')`, or use
`executeSqlFiles()` with an ordered list. Put one complete SQL statement in each
file. See [Database Migrations](https://github.com/phalcon-kit/core/blob/master/guides/database-migrations.md)
for a complete example and rollback boundaries.

The helper scripts use the standalone `phalcon-migrations` binary with its direct
`list`, `generate`, and `run` actions. Generation preserves existing files unless
`--force` is supplied deliberately and omits hard-coded referenced schemas:

```shell
./scripts/migration-list.sh
./scripts/migration-generate.sh
./scripts/migration-run.sh
./scripts/migration-rollback.sh --version=<previous-app-version>
```

The development Composer install applies the reviewed PHP 8.5 migration-runner
and Phalcon IDE-stub patches from `patches/`; commit `patches.lock.json` with the
application. See [patch maintenance](patches/README.md). Migration tooling is
unavailable in a production installation made with `--no-dev`; run it from the
appropriate build/deployment environment.

Generate missing model layers from the connected database:

```shell
./scripts/generate-models.sh
```

This command refuses `--force`, keeps concrete model business logic intact,
and makes generated abstracts inherit from the application-owned
`App\Models\AbstractModel` extension point.

Regenerate generated layers while preserving concrete application models:

```shell
./scripts/regenerate-models.sh
```

Both helpers deliberately skip controllers and generated tests; those remain
application-owned code in this skeleton.

PowerShell equivalents are included for Windows.

## Quality Checks

The lockfile is committed deliberately: every newly created application starts
from the exact dependency graph validated by this repository.

```shell
composer qa       # Composer validation/audit, PHPCS, PHPStan, PHPUnit
composer phpcs    # PSR-12-based coding standards
composer phpstan  # Static analysis
composer phpunit  # Unit tests
composer phpcbf   # Apply safe coding-standard fixes
```

Run `composer update` intentionally and review both `composer.json` and
`composer.lock` before committing dependency changes.

## Documentation

- [Getting Started](https://phalcon-kit.github.io/docs/guides/getting-started/)
- [Application Architecture](https://phalcon-kit.github.io/docs/guides/architecture/)
- [Configuration](https://phalcon-kit.github.io/docs/guides/configuration/)
- [Database Scaffolding](https://phalcon-kit.github.io/docs/guides/database-scaffolding/)
- [REST APIs](https://phalcon-kit.github.io/docs/guides/rest-api/)
- [PhalconKit API Reference](https://phalcon-kit.github.io/docs/api/)

## Support And Security

Use the [App issue tracker](https://github.com/phalcon-kit/app/issues) for
skeleton, installation, entrypoint, or helper-script problems. Use the
[Core issue tracker](https://github.com/phalcon-kit/core/issues) for reusable
framework behavior.

Please read [SECURITY.md](SECURITY.md) before reporting a vulnerability and
[CONTRIBUTING.md](CONTRIBUTING.md) before proposing a change.
Applications upgrading from an older skeleton should also read
[UPGRADE.md](UPGRADE.md).

## Package History

Phalcon Kit App continues the application skeleton formerly published for
Zemit CMS. New projects should use `phalcon-kit/app` and `phalcon-kit/core`.

## License

Phalcon Kit App is released under the [BSD 3-Clause License](LICENSE).

Copyright © 2017-present, Phalcon Kit Team.
