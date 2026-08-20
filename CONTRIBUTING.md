# Contributing

Thanks for improving the Phalcon Kit application skeleton.

Keep changes focused on what every newly created application should receive.
Reusable framework behavior belongs in
[`phalcon-kit/core`](https://github.com/phalcon-kit/core).

## Development

```shell
composer install
cp .env.example .env
composer qa
```

When changing the project layout, update Linux and PowerShell helpers together,
verify commands from outside the repository root, and update the public
documentation. When changing dependencies, commit the resulting lockfile.

Pull requests should explain the user-visible behavior, compatibility impact,
and validation performed.
