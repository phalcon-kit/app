# Upgrading Phalcon Kit App

## From 1.x To 2.0

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

Keep the root configuration class at `src/Config/Config.php` with the existing
`App\Config\Config` namespace and class name. After moving the files, run:

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
