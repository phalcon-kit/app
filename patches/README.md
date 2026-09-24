# Dependency Compatibility Patches

These reviewed copies come from the locked `phalcon-kit/core` revision. Keeping
patches in the application makes fresh Composer installations reproducible;
patch resolution must not depend on an already populated `vendor/` directory.

Core declares the three Phalcon IDE-stub patches. App also declares the migration
runner's PHP 8.5 nullable-type patch. Composer Patches de-duplicates the shared
migration patch by URL when Core declares it too. The plugin is development-only,
as are the affected migrations/stub packages.

When upgrading Core, compare its patch files with these copies, review any changes,
run `composer patches-relock`, reinstall affected packages, and commit the patch
files and `patches.lock.json` with the application lockfile. Do not disable signing
or suppress deprecations to bypass a failing compatibility check.
