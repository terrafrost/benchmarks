#!/bin/sh

set -e
set -x

sudo apt-get -y install libssh2-1 libssh2-1-dev
sudo pecl install ssh2-1.2
echo "extension=ssh2.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
