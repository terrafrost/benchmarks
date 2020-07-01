<?php
require __DIR__ . '/vendor/autoload.php';

$start = microtime(true);

define('NET_SFTP_UPLOAD_QUEUE_SIZE', 1);

$ssh = ssh2_connect('127.0.0.1');
ssh2_auth_password($ssh, 'phpseclib', 'phpseclib');
$sftp = ssh2_sftp($ssh);

$fp = fopen('ssh2.sftp://' . intval($sftp) . '/home/phpseclib/1mb', 'w');
fwrite($fp, str_repeat('a', 10 * 1024 * 1024));
$elapsed = microtime(true) - $start;
echo "libssh2 / upload took $elapsed seconds\r\n";

$start = microtime(true);
$fp = fopen('ssh2.sftp://' . intval($sftp) . '/home/phpseclib/1mb', 'r');
$str = '';
while (!feof($fp)) {
    $str.= fread($fp, 1024);
}
$elapsed = microtime(true) - $start;
echo "libssh2 / download took $elapsed seconds\r\n";
$hash = md5($str);
$str = '';

$start = microtime(true);

$sftp = new \phpseclib3\Net\SFTP('127.0.0.1');
$sftp->login('phpseclib', 'phpseclib');

$sftp->put('1mb', str_repeat('a', 10 * 1024 * 1024));
$elapsed = microtime(true) - $start;
echo "phpseclib / upload took $elapsed seconds\r\n";

$start = microtime(true);
$hash2 = md5($sftp->get('1mb'));
$elapsed = microtime(true) - $start;
echo "phpseclib / download took $elapsed seconds\r\n";

echo $hash === $hash2 ? 'downloads matched' : 'downloads did not match';
echo "\r\n";