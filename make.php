#!/usr/bin/env php
<?php
$srcRoot    = __DIR__ . DIRECTORY_SEPARATOR . 'src';
$buildRoot  = __DIR__ . DIRECTORY_SEPARATOR . 'build';
$assetsRoot = __DIR__ . DIRECTORY_SEPARATOR . 'assets';

$file = 'file_get_contents';

$phar = new Phar(
    $buildRoot . DIRECTORY_SEPARATOR . 'main.phar',
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    'main.phar'
);

$phar['main.php']          = $file(__DIR__ . DIRECTORY_SEPARATOR . 'main.php');
$phar['SqlScan.php']       = $file($srcRoot . DIRECTORY_SEPARATOR . 'SqlScan.php');
$phar['WebsiteParser.php'] = $file($srcRoot . DIRECTORY_SEPARATOR . 'WebsiteParser.php');
$phar['Cli.php']           = $file($srcRoot . DIRECTORY_SEPARATOR . 'Cli.php');
$phar['sql.ini']           = $file($assetsRoot . DIRECTORY_SEPARATOR . 'sql.ini');
$phar['banner.txt']        = $file($assetsRoot . DIRECTORY_SEPARATOR . 'banner.txt');

$phar->compressFiles(Phar::BZ2);
$phar->setSignatureAlgorithm(Phar::SHA1, sha1('Cvar1984'));
$phar->setStub("#!/usr/bin/env php\n" . $phar->createDefaultStub('main.php'));
chmod($buildRoot . DIRECTORY_SEPARATOR . 'main.phar', 0777);
