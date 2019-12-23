<?php
namespace Cvar1984\SqlScan;
use Cvar1984\SqlScan\Cli as Cout;

class SqlScan  {
    protected static $sql;

    function __construct()
    {
        // setup
        $sql = file_get_contents('phar://main.phar/assets/sql.ini');
        if (!$sql) {
            Cout::printError('Sql word not found');
        }

        Cout::printSuccess('Sql word included');
        $sql = trim($sql, ',');
        self::$sql = explode(',', $sql);
    }

    public function scan(string $url, string $filename)
    {
        $parser = new \Cvar1984\SqlScan\WebsiteParser($url);
        if (empty($url)) {
            Cout::printError('Please insert url');
        }

        Cout::printLine('Extracting : ' . $url);
        $url   = $parser->getHrefLinks();
        $count = sizeof($url);
        Cout::printLine('Total raw urls : ' . $count);

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
            Cout::printLine('Total available urls : ' . $count);
            foreach ($urlz as $urls) {
                $urls = str_replace('=', '=\'', $urls);
                //Cout::printLine('Testing : ' . $urls);
                $progressBar->advance();
                $result = @file_get_contents($urls);

                foreach (self::$sql as $sqli) {
                    if (preg_match('/' . $sqli . '/', $result)) {
                        Cout::printSuccess('Hit (' . $sqli . ')');
                        $file = @fopen($filename, 'a');
                        if (!$file) {
                            Cout::printWarning('warning can\'t write result');
                        } else {
                            fprintf($file, $urls . PHP_EOL);
                            fclose($file);
                        }
                        break;
                    }
                }
            }
        } else {
            Cout::printError('Can\'t continue, urls is empty');
        }
    }
}
