# Upgrading Phalcon Kit App

## From 2.x To 4.0

App skips 3.x so that App and Core begin the 4.x line together at **4.0.0**.
Only the 4.x line is maintained. Earlier App and Core releases are end of life,
with no support, bug fixes, security fixes, or backports.

Prepare the upgrade in an isolated checkout and preserve the existing
application's lockfile until its migration has been validated.

### Dependencies And Runtime

- Keep PHP 8.5 and upgrade the native Phalcon extension to `^5.22.0` in CLI,
  PHP-FPM, queue, and WebSocket runtimes.
- Use matching `phalcon/ide-stubs` `^5.22.0` for development.
- Require Core `^4.0` and lock the tested stable tag. Use `dev-master` only for
  deliberate development testing.
- Review and commit the application lockfile. Existing applications can adopt
  these changes directly; their copied skeleton files are application-owned.

### Core Changes

Read the complete
[Core 4.0 upgrade inventory](https://github.com/phalcon-kit/core/blob/master/guides/upgrading-4.0.md).
Remove references to retired catalog/CMS classes, dynamic database configuration,
and the catalog faker task. Keep the existing application namespace, entrypoints,
module wrappers, and app-owned models.

Database maintenance now requires explicit application `deployment` instructions.
Unconfigured operations do nothing and no default account is seeded. Define only
the tables and model seed rows the application owns. Existing tables and data
are preserved by the package upgrade; do not run historical Core migrations as
a cleanup step.

The new skeleton removes its empty `1.0.0` migration placeholder. Existing
applications retain any history already recorded for that version.

Core now ships a 29-table fresh baseline and reusable SQL-file migration helpers.
Do not copy that baseline into an existing application's pending migrations.
Existing applications review their own OAuth token widths, identifier lengths,
engines, collations, and indexes through separate data-preserving migrations.

App's migration scripts now invoke the standalone binary directly (`run`, not
`migration run`). Unix and PowerShell helpers no longer force generated files
to be overwritten and omit referenced database names when generating migrations.
The development Composer install includes a type-only PHP 8.5 compatibility
patch for `phalcon/migrations` 3.0.1 and matching Core IDE-stub patches. Keep the
reviewed `patches/` copies and patch lockfile when adopting this tool setup.

### Application Acceptance

Run `composer qa`, CLI help from both the project and another directory, HTTP
route checks, and the optional WebSocket checks appropriate to the application.
Exercise authentication/reset delivery, permissions, nested model writes, and
any retained Core features against disposable application data.

The published skeleton passes its dependency CI matrix, native migration checks,
PowerShell checks, and fresh public installation checks. Applications still own
acceptance of production data, external providers, and browser/mobile identity
flows before rollout. Keep existing migration history and review data changes
separately from the package update.

## From 1.x To 2.0

This section records the historical layout migration. Both version lines are
unsupported; apply relevant layout changes before following the 4.0 guide above.

App 2.0 establishes a modern project layout. Existing applications are not
rewritten automatically; apply these changes deliberately in your own project.

### Application Classes

Move the application namespace from `app/` to `src/` and update Composer:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

Move the root configuration class to `src/Config.php` and rename it from
`App\Config\Config` to `App\Config`. Update imports in the application
bootstrap, devtools entrypoint, and tests. After moving the files, run:

```shell
composer dump-autoload
```

### Entrypoints And Helpers

- Use `public/index.php` as the only HTTP entrypoint.
- Use `bin/phalcon-kit` as the application CLI entrypoint.
- Move an existing root WebSocket entrypoint to `bin/websocket` and bootstrap
  it with `Bootstrap::MODE_WS`.
- Move migration, generation, and maintainer helpers from `bin/` to `scripts/`.
- Require the root `bootstrap.php` from runtime entrypoints.
- Remove the legacy root `index.php`, `loader.php`, `phalcon-kit`, and
  `phalcon-kit.bat` files after deployment configuration has been updated.

Update process supervisors, containers, CI workflows, cron jobs, and deployment
scripts that reference the old paths before removing the compatibility files.

### Modules And WebSocket

App 2.0 keeps project-owned Frontend, Admin, API, CLI, and optional WebSocket
module wrappers. Register the `ws` module and `router.ws` namespace when
migrating an existing WebSocket application. The default example binds Swoole
to `127.0.0.1:8081` and grants only `MainTask::listen` to the `ws` role.

The Admin module is no longer granted to the anonymous `everyone` role by the
skeleton. Add an explicit role permission if an existing application intends
to expose an Admin controller.

Swoole remains optional. Install it in the worker runtime and keep
`swoole/ide-helper` as a development-only package for static analysis.

### Runtime Paths

Set `APP_PATH` to the new source directory:

```php
defined('APP_PATH') || define('APP_PATH', ROOT_PATH . 'src/');
```

Keep the web server document root pointed at `public/`. Runtime state belongs
under `storage/`, including `storage/log/` and `storage/tmp/`.

### Verification

Run the complete project gate and smoke-test both web and CLI entrypoints:

```shell
composer qa
./bin/phalcon-kit --help
php -S 127.0.0.1:8080 -t public public/index.php
```
