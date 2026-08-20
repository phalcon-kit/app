#!/usr/bin/env pwsh

# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit team
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

. "$PSScriptRoot\set-working-directory.ps1"

php ".\bin\phalcon-kit" cli scaffold run `
    --directory="./" `
    --src-dir="src/" `
    --namespace="App" `
    $args
