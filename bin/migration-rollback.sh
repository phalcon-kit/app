#!/bin/bash

# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.

./vendor/bin/phalcon migration rollback --config=./devtools.php --directory=./ --migrations=./resources/migrations/ --no-auto-increment --force --verbose --log-in-db "$@"
