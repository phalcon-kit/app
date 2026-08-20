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

cd "$project_root"
exec ./bin/phalcon-kit cli scaffold run \
    --directory=./ \
    --src-dir=src/ \
    --namespace=App \
    "$@"
