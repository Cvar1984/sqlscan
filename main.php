<?php
require __DIR__ . '/vendor/autoload.php';
use Cvar1984\SqlScan\SqlScan;
use Cvar1984\SqlScan\Cli as Cout;
use Cvar1984\SqlScan\Dorker;

try {
    $count = scandir('phar://main.phar/assets/');
    $count = sizeof($count);
    $path = 'phar://main.phar/assets/banner_' . rand(0, ($count - 2)) . '.txt';
    $file = fopen($path, 'r');
    if ($file) {
        $file = fread($file, filesize($path));
        Cout::printStandar($file);
    } else {
        Cout::printWarning('can\'t load banner');
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
                        $file = trim($file, " \n");
                        $url  = explode("\n", $file);
                        foreach ($url as $url) {
                            $sql->scan($url, 'result.txt');
                        }
                    } else {
                        Cout::printError('File not exists ' . $pwd);
                    }
                }
                break;

            case '--dork':
                $dork = new Dorker($argv[1], 'result_url.txt');
                break;

            case '--shell':
                Cout::printError('under development');
                break;

            default:
                Cout::printAsk('Available method : --scan, --dork, --shell');
                Cout::printError('Undefined method : ' . $argv[2]);
                break;
        }
    } else {
        Cout::printAsk('Usage : sqlscan [required] [option]');
        Cout::printLine('Examples : sqlscan http://hackme.org --scan');
    }
} catch (Exception $e) {
    fprintf(STDERR, '%s%s', $e->getMessage(), PHP_EOL);
    exit(1);
}
