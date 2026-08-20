#!/usr/bin/env bash

set -euo pipefail

# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit team
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
project_root="$(dirname -- "$script_dir")"

for argument in "$@"; do
    if [[ "$argument" == "--force" ]]; then
        printf 'Refusing --force: generate-models must not overwrite concrete model business logic.\n' >&2
        exit 2
    fi
done

cd "$project_root"
exec ./bin/phalcon-kit cli scaffold run \
    --directory=./ \
    --src-dir=src/ \
    --namespace=App \
    --models-extend='App\Models\AbstractModel' \
    --no-controllers \
    --no-tests \
    --no-license \
    --protected-properties \
    "$@"
