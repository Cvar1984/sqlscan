<?php
require 'phar://main.phar/WebsiteParser.php';
require 'phar://main.phar/SqlScan.php';
require 'phar://main.phar/Cli.php';
use Cvar1984\Sqlscan\SqlScan;
use Cvar1984\SqlScan\Cli;

try {
    $print = new Cli();
    $file  = file_get_contents('phar://main.phar/banner.txt');
    if ($file) {
        $print->printStandar($file);
    } else {
        $print->printWarning('can\'t load banner');
    }
    if ($argc >= 3) {
        switch ($argv[2]) {
            case '--scan':
                $sql = new Sqlscan();
                $url = trim($argv[1]);

                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $sql->scan($url, 'result.txt');
                } else {
                    $pwd = getcwd() . DIRECTORY_SEPARATOR . $url;
                    if (file_exists($pwd)) {
                        $file = file_get_contents($pwd);
                        $file = trim($file, "\n");
                        $url  = explode("\n", $file);
                        foreach ($url as $url) {
                            $sql->scan($url, 'result.txt');
                        }
                    } else {
                        $print->printError('File not exists ' . $pwd);
                    }
                }
                break;

            case '--dork':
                $print->printError('under development');
                break;

            case '--shell':
                $print->printError('under development');
                break;

            default:
                $print->printAsk('Available method : --scan, --dork, --shell');
                $print->printError('Undefined method : ' . $argv[2]);
                break;
        }
    } else {
        $print->printAsk('Usage : sqlscan [required] [option]');
        $print->printLine('Examples : sqlscan http://hackme.org --scan');
    }
} catch (Exception $e) {
    fprintf(STDERR, '%s%s', $e->getMessage(), PHP_EOL);
    exit(1);
}
