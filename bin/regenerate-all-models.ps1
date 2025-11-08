#!/usr/bin/env pwsh

# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.

. "$PSScriptRoot\Set-WorkingDirectory.ps1" -ScriptFilePath $MyInvocation.MyCommand.Definition

# 1. Remove any existing Abstract*.php in app/Models/Abstracts/
Get-ChildItem -Path ".\app\Models\Abstracts" -Filter "Abstract*.php" -Recurse |
    Remove-Item -Force

# 2. Generate all models (Phalcon)
php ".\vendor\bin\phalcon" all-models `
    --config="./devtools.php" `
    --get-set `
    --camelize `
    --mapcolumn `
    --abstract `
    --doc `
    --directory="./" `
    --output="./app/Models/Abstracts" `
    --relations `
    --fk `
    --force `
    --namespace="App\Models\Abstracts" `
    --extends="\App\Models\AbstractModel" `
    $args

# 3 & 4 & 5. Transform each generated file
#    - Insert "parent::initialize();" before lines containing "$this->setSchema"
#    - Comment out the actual "$this->setSchema" call
#    - Replace "public function initialize()" with "public function initialize() :void"
Get-ChildItem -Path ".\app\Models\Abstracts" -Filter "*.php" -Recurse | ForEach-Object {
    $file = $_.FullName
    $content = Get-Content $file

    # Insert 'parent::initialize();' on the line before any line matching '$this->setSchema'
    $content = $content | ForEach-Object {
        if ($_ -match '\$this->setSchema') {
            "        parent::initialize();"
            $_
        }
        else {
            $_
        }
    }

    # Comment out "$this->setSchema"
    $content = $content -replace ' \$this->setSchema', ' // $this->setSchema'

    # Replace "public function initialize()" with "public function initialize() :void"
    $content = $content -replace 'public function initialize\(\)', 'public function initialize() :void'

    # Write back to file
    Set-Content -Path $file -Value $content
}
