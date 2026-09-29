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

## Documentation

The README should help someone create and run their own application. Put
framework usage recipes in Core's `guides/`, then synchronize them into Docs with
`python bin/sync-guides.py --core ../core` from that repository. Keep current setup
commands, task names, defaults, and expected results consistent across all three.

Use neutral schemas and synthetic data. Private applications can inform the
choice of scenario, but their names, domains, identifiers, data, and proprietary
rules must never enter public examples. Keep release history in the changelog
and upgrade instructions in Core's `guides/migrations/`. Follow its shared
scope/preparation/changes/verification/rollback structure, and keep the
installation path focused on current behavior.
