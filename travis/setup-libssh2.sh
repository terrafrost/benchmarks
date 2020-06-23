#!/bin/sh

set -e
set -x

sudo apt-get update
sudo apt-get -y install libssh2-1 libssh2-1-dev
pecl install -f ssh2-1.2 < .noninteractive
echo "extension=ssh2.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
sudo useradd --create-home --base-dir /home "phpseclib"
echo "phpseclib:phpseclib" | sudo chpasswd
