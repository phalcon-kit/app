# Phalcon Kit App

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
- Phalcon 5.19.x
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
composer create-project phalcon-kit/app:^2.0 my-app
cd my-app
cp .env.example .env
composer qa
```

Update `.env` for the application and database before enabling model-backed
services. Do not commit `.env` or production credentials.

For local development with PHP's built-in server:

```shell
php -S 127.0.0.1:8080 -t public public/index.php
```

For Apache, Nginx, Caddy, containers, or a platform proxy, configure `public/`
as the document root. Never expose the repository root as the web root.

## Project Layout

```text
src/
  Bootstrap.php         Application bootstrap
  Config/Config.php     Modules, providers, aliases, and permissions
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
`.env`; structural application policy belongs in `src/Config/Config.php`.

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

The migration helpers use the maintained `phalcon/migrations` package:

```shell
./scripts/migration-list.sh
./scripts/migration-generate.sh
./scripts/migration-run.sh
./scripts/migration-rollback.sh --version=1.0.0
```

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
Applications upgrading from the 1.x skeleton should also read
[UPGRADE.md](UPGRADE.md).

## Package History

Phalcon Kit App continues the application skeleton formerly published for
Zemit CMS. New projects should use `phalcon-kit/app` and `phalcon-kit/core`.

## License

Phalcon Kit App is released under the [BSD 3-Clause License](LICENSE).

Copyright © 2017-present, Phalcon Kit Team.
