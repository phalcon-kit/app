# Phalcon Kit App

Start a PHP application with PhalconKit's HTTP, REST, CLI, and optional WebSocket
structure already connected. Add your tables, generate models, and define the
API your application needs.

**[Get started](https://phalcon-kit.github.io/docs/guides/getting-started/)** ·
**[Build your first API](https://phalcon-kit.github.io/docs/guides/first-rest-resource/)** ·
**[REST handbook](https://phalcon-kit.github.io/docs/guides/rest-api/)** ·
**[All guides](https://phalcon-kit.github.io/docs/guides/)**

## Create An Application

Requires PHP 8.5+, the native Phalcon extension satisfying `^5.22.0`, and Composer 2.

```shell
composer create-project phalcon-kit/app my-api
cd my-api
cp .env.example .env
composer check-platform-reqs
php -S 127.0.0.1:8080 -t public public/index.php
```

On PowerShell, use `Copy-Item .env.example .env`. In another terminal:

```shell
curl --include http://127.0.0.1:8080/api
```

Expected: HTTP 200 with `code: 200`, `response: []`, and `view: []` in the JSON
envelope. This verifies bootstrap without a database.

The development server is for local use. In deployment, serve only `public/`
through your web server/PHP-FPM setup.

## Connect Your Database

Create a database and account, then configure `.env`:

```ini
APP_NAME="Project API"
DATABASE_HOST=127.0.0.1
DATABASE_PORT=3306
DATABASE_DBNAME=my_api
DATABASE_USERNAME=my_api
DATABASE_PASSWORD="your-private-password"
```

Keep secrets in the environment and application structure in `src/Config.php`.
For MariaDB, configure the
[dedicated driver](https://phalcon-kit.github.io/docs/guides/configuration/#mysql-and-mariadb)
to avoid MySQL-only connection options.

Your own resource tables can stand alone. To use Core's built-in user/role and
other feature models in a fresh database with an empty migration tree:

```shell
mkdir -p resources/migrations
cp -R vendor/phalcon-kit/core/resources/migrations/4.0.0 resources/migrations/
./scripts/migration-list.sh
./scripts/migration-run.sh
```

This installs tables, without creating accounts or seed data. Use
[Database Migrations](https://phalcon-kit.github.io/docs/guides/database-migrations/)
for application SQL migrations and deployment commands.

## Build A Resource

After creating a table:

```shell
./scripts/generate-models.sh --table=project
```

After changing its schema:

```shell
./scripts/regenerate-models.sh --table=project
```

The first command creates missing models. The second refreshes generated
abstracts/interfaces/enums while preserving concrete model classes. Both have
PowerShell `.ps1` equivalents. Concrete models hold your business logic.

Add an API controller under `src/Modules/Api/Controllers/`, then configure its
field policies and controller/model permissions. Follow the
[complete Project tutorial](https://phalcon-kit.github.io/docs/guides/first-rest-resource/)
for SQL, controller code, requests, and actual response shapes.

## Add Authentication

Generate a private JWT signing key once per environment:

```shell
php -r 'echo "Aa1!" . bin2hex(random_bytes(64)), PHP_EOL;'
```

Store it as `SECURITY_JWT_PASSPHRASE` in `.env` or a secret store. Use a separate
private `CRYPT_KEY` when using encryption. Keep both out of version control.

The [authentication guide](https://phalcon-kit.github.io/docs/guides/authentication/)
shows how to register the auth controller, create an account with the existing
CLI user task, assign a role, and use login/refresh/logout. Default stateful
identity requires the bearer token **and** the session cookie. The guide includes
local HTTP cookie settings and complete `curl` examples.

## Where Your Code Goes

| Path | Purpose |
| --- | --- |
| `src/Config.php` | Modules, providers, model aliases, permissions |
| `src/Models/` | Concrete models and business methods |
| `src/Models/Abstracts/` | Generated schema layer |
| `src/Modules/Api/Controllers/` | REST resources and workflow endpoints |
| `src/Modules/Cli/Tasks/` | Commands, including scaffold and account-task bridges |
| `src/Modules/Ws/Tasks/` | Optional WebSocket protocol |
| `resources/migrations/` | Your schema history |
| `tests/Unit/` | Application tests |
| `storage/` | Runtime cache, logs, files |
| `public/` | Web document root |

## Common Tasks

| Task | Command or guide |
| --- | --- |
| Inspect CLI usage | `./bin/phalcon-kit --help` |
| Create or change an account | [CLI user commands](https://phalcon-kit.github.io/docs/guides/authentication/#create-an-account-with-the-cli) |
| Write a command | [CLI tasks](https://phalcon-kit.github.io/docs/guides/cli-tasks/) |
| Filter, sort, page, and count | [REST filtering](https://phalcon-kit.github.io/docs/guides/rest-filtering/) |
| Save batches and child records | [Writes](https://phalcon-kit.github.io/docs/guides/rest-writes/) and [relationships](https://phalcon-kit.github.io/docs/guides/rest-relationships/) |
| Export CSV/JSON | [Exports](https://phalcon-kit.github.io/docs/guides/rest-aggregates/#export-a-page) |
| Run the optional WebSocket worker | `./bin/websocket` (requires Swoole) |
| Configure HTTPS/PHP-FPM and WebSockets | [Web servers](https://phalcon-kit.github.io/docs/guides/web-server-and-websocket/) |
| Run application checks | `composer qa` |

The WebSocket starter accepts `{"type":"ping"}` and returns `{"type":"pong"}`.
Authentication, subscriptions, and notification delivery are application-owned;
the guide explains a concrete protocol and multi-worker/reconnect considerations.

Keep your application lockfile committed. Use `composer install` in deployment,
and ensure migration tooling is available in the environment that runs migrations.
Keep debug output disabled in shared environments.

For an existing application, use the [migration guides](https://phalcon-kit.github.io/docs/guides/migrations/)
for package, layout, REST, and Core changes.

## Help And Project Information

- [User documentation](https://phalcon-kit.github.io/docs/)
- [Usage discussions](https://github.com/orgs/phalcon-kit/discussions)
- [Report a skeleton issue](https://github.com/phalcon-kit/app/issues)
- [Changelog](CHANGELOG.md) · [License](LICENSE)
- [Security policy](https://github.com/phalcon-kit/core/blob/master/SECURITY.md)
- [Contribute to PhalconKit](https://github.com/phalcon-kit/core/blob/master/CONTRIBUTING.md)
