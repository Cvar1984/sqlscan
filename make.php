#!/usr/bin/env php
<?php
$srcRoot = 'src';
$buildRoot = 'build';

$phar = new Phar($buildRoot . "/main.phar",FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, "main.phar");
$phar["main.php"] = file_get_contents($srcRoot . "/main.php");
$phar["website_parser.php"] = file_get_contents($srcRoot . "/website_parser.php");
$phar['sql.ini']=file_get_contents($srcRoot.'/sql.ini');
$phar->setStub( "#!/usr/bin/env php\n".$phar->createDefaultStub("main.php"));
chmod($buildRoot.'/main.phar',0777);
