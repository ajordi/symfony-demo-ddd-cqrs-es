#!/bin/bash

set -Eeuo pipefail

echo "*** Waiting for MySQL to become available ..."

while ! mysql -h mysql -P 3306 -u user -psecret -D db -e 'SELECT 1'  &> /dev/null; do
    sleep 1
done

echo "*** Connected with MySQL."
