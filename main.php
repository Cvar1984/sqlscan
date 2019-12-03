<?php
require 'phar://main.phar/WebsiteParser.php';
require 'phar://main.phar/Sqlscan.php';
require 'phar://main.phar/Cli.php';
use Cvar\Sqlscan\Sqlscan;
use Cvar\Sqlscan\Cli;

try {
    $print = new Cli();
    $file = file_get_contents('phar://main.phar/banner.txt');
    if ($file) {
        $print->printStandar($file);
    }
    else {
        $print->printWarning('can\'t load banner');
    }
    if ($argc >=3) {
        if($argv[2] == '--scan') {
            $sql = new Sqlscan();
            $url = trim($argv[1]);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $sql->scan($url, 'result.txt');
            }
            else {
                $pwd = getcwd() . DIRECTORY_SEPARATOR . $url;
                if (file_exists($pwd)) {
                    $file = file_get_contents($pwd);
                    $file = trim($file, "\n");
                    $url = explode("\n", $file);
                    foreach ($url as $url) {
                        $sql->scan($url, 'result.txt');
                    }
                }
                else {
                    $print->printError('File not exists ' . $pwd);
                }
            }
        }
        elseif($argv[2] == '--dork') {
            $print->printError('under development');
        }
        elseif($argv[2] == '--shell') {
            $print->printError('under development');
        }
        elseif($argv[2] == '--help') {
            $print->printAsk('method : --scan, --dork, --shell');
        }
    }
    else {
        $print->printError('Need argument, eg : sqlscan http://example.net --scan');
    }
}
catch (Exception $e) {
    fprintf(STDERR, '%s%s', $e->getMessage(), PHP_EOL);
    exit(1);
}
