<?php
require __DIR__ . '/vendor/autoload.php';

phpinfo();
exit;

$start = microtime(true);

$ssh = ssh2_connect('127.0.0.1');
ssh2_auth_password($ssh, 'phpseclib', 'phpseclib');

$sftp = ssh2_sftp($ssh);

$fp = fopen('ssh2.sftp://' . intval($sftp) . '/home/phpseclib/1mb', 'w');

fwrite($fp, str_repeat('a', 1024 * 1024));
$elapsed = microtime(true) - $start;

echo "libssh2 took $elapsed seconds\r\n";

$start = microtime(true);

$sftp = new \phpseclib3\Net\SFTP('127.0.0.1');
$sftp->login('phpseclib', 'phpseclib');

$sftp->put('1mb', str_repeat('a', 1024 * 1024));

$elapsed = microtime(true) - $start;

echo "phpseclib took $elapsed seconds\r\n";