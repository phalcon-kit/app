#!/usr/bin/env pwsh

# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.

. "$PSScriptRoot\Set-WorkingDirectory.ps1" -ScriptFilePath $MyInvocation.MyCommand.Definition

php ".\vendor\bin\phalcon" migration list `
    --config=".\devtools.php" `
    --directory=".\" `
    --migrations=".\resources\migrations\" `
    --log-in-db `
    $args
