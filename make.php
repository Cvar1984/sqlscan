#!/usr/bin/env php
<?php
$srcRoot = __DIR__ . DIRECTORY_SEPARATOR . 'src';
$buildRoot = __DIR__ . DIRECTORY_SEPARATOR . 'build';

$phar = new Phar(
    $buildRoot . DIRECTORY_SEPARATOR . 'main.phar',
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    'main.phar'
);
$phar['main.php'] = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'main.php');
$phar['Sqlscan.php'] = file_get_contents($srcRoot . DIRECTORY_SEPARATOR . 'Sqlscan.php');
$phar['WebsiteParser.php'] = file_get_contents($srcRoot . DIRECTORY_SEPARATOR . 'WebsiteParser.php');
$phar['sql.ini'] = file_get_contents($srcRoot . DIRECTORY_SEPARATOR . 'sql.ini');
$phar['banner.txt'] = file_get_contents($srcRoot . DIRECTORY_SEPARATOR . 'banner.txt');
$phar->compressFiles(Phar::BZ2);
$phar->setSignatureAlgorithm(Phar::SHA1, sha1('Cvar1984'));
$phar->setStub("#!/usr/bin/env php\n" . $phar->createDefaultStub('main.php'));
chmod($buildRoot . DIRECTORY_SEPARATOR . 'main.phar', 0777);
