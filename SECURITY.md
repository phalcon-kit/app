# Security Policy

## Supported Versions

Only App **4.x**, paired with Core **4.x**, is maintained. All earlier App and
Core releases are end of life, with no support, bug fixes, security fixes, or
backports. Historical tags remain available for reproducible installs.

App and Core 4.0.0 are still unreleased, so there is currently no supported stable
release. `master` is the development preview. See [UPGRADE.md](UPGRADE.md) and
the [Core security policy](https://github.com/phalcon-kit/core/blob/master/SECURITY.md).

Applications created from a skeleton release own their copied files. Update
their direct dependencies and manually adopt relevant skeleton hardening changes.

## Reporting A Vulnerability

Do not open a public issue for a suspected vulnerability. Use GitHub's private
security advisory reporting for
[`phalcon-kit/app`](https://github.com/phalcon-kit/app/security/advisories/new).

Include the affected version, reproduction details, expected impact, and any
known mitigations. Never include production credentials, customer data, or
private infrastructure details.
