<?php
namespace Cvar1984\SqlScan;
use Cvar1984\SqlScan\Cli;

class SqlScan  {
    protected static $sql;

    function __construct()
    {
        // setup
        $sql = file_get_contents('phar://main.phar/assets/sql.ini');
        if (!$sql) {
            Cli::printError('Sql word not found');
        }

        Cli::printSuccess('Sql word included');
        $sql = trim($sql, ',');
        self::$sql = explode(',', $sql);
    }

    public function scan(string $url, string $filename)
    {
        $parser = new \Cvar1984\SqlScan\WebsiteParser($url);
        if (empty($url)) {
            Cli::printError('Please insert url');
        }

        Cli::printLine('Extracting : ' . $url);
        $url   = $parser->getHrefLinks();
        $count = sizeof($url);
        Cli::printLine('Total raw urls : ' . $count);

        if (!empty($count)) {
            $urlz = array();
            foreach ($url as $urls) {
                if (pathinfo($urls[0], PATHINFO_EXTENSION) == 'pdf') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'zip') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'mp4') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'mp3') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'tar') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'jpg') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'png') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'gif') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'm4a') continue;
                elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == '3gp') continue;
                if (!preg_match('/=/', $urls[0])) continue;
                $urlz[] = $urls[0];
            }
            $count = count($urlz);
            $progressBar = new \ProgressBar\Manager(0, $count);
            Cli::printLine('Total available urls : ' . $count);
            foreach ($urlz as $urls) {
                $urls = str_replace('=', '=\'', $urls);
                //Cli::printLine('Testing : ' . $urls);
                $progressBar->advance();
                $result = @file_get_contents($urls);

                foreach (self::$sql as $sqli) {
                    if (preg_match('/' . $sqli . '/', $result)) {
                        Cli::printSuccess('Hit (' . $sqli . ')');
                        $file = @fopen($filename, 'a');
                        if (!$file) {
                            Cli::printWarning('warning can\'t write result');
                        } else {
                            fprintf($file, $urls . PHP_EOL);
                            fclose($file);
                        }
                        break;
                    }
                }
            }
        } else {
            Cli::printError('Can\'t continue, urls is empty');
        }
    }
}
