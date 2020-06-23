#!/bin/sh

set -e
set -x

sudo apt-get update
sudo apt-get -y install libssh2-1 libssh2-1-dev
cd /tmp
wget https://pecl.php.net/get/ssh2-1.2.tgz
tar xvf ssh2-1.2.tgz
cd ssh2-1.2
phpize
./configure
make
make install
echo "extension=ssh2.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
sudo useradd --create-home --base-dir /home "phpseclib"
echo "phpseclib:phpseclib" | sudo chpasswd
