<?php
require 'phar://main.phar/WebsiteParser.php';
require 'phar://main.phar/Sqlscan.php';
use Cvar\Sqlscan\Sqlscan;
try {
    $file = file_get_contents('phar://main.phar/banner.txt');
    fprintf(STDOUT, '%s', $file);
    if ($argc >= 2) {
        $url = trim($argv[1]);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $sql = new Sqlscan($url);
        } else {
            $pwd = getcwd() . DIRECTORY_SEPARATOR . $url;
            if (file_exists($pwd)) {
                $file = file_get_contents($pwd);
                $file = trim($file, "\n");
                $url = explode("\n", $file);
                foreach ($url as $url) {
                    $sql = new Sqlscan($url);
                }
            } else {
                throw new Exception("File not exists {$pwd}");
            }
        }
    } else {
        throw new Exception("Need argument, eg : sqlscan http://example.net");
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
