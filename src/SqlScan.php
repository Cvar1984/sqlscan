<?php
namespace Cvar1984\SqlScan;

class SqlScan  {
    protected static $sql;

    function __construct()
    {
        // setup
        $print = new \Cvar1984\SqlScan\Cli();
        $sql = file_get_contents('phar://main.phar/sql.ini');
        if (!$sql) {
            $print->printError('Sql word not found');
        }

        $print->printSuccess('Sql word included');
        $sql = trim($sql, ',');
        self::$sql = explode(',', $sql);
    }

    public function scan(string $url, string $filename)
    {
        $print  = new \Cvar1984\SqlScan\Cli();
        $parser = new \Cvar1984\SqlScan\WebsiteParser($url);
        if (empty($url)) {
            $print->printError('Please insert url');
        }

        $print->printLine('extracting links');
        $url   = $parser->getHrefLinks();
        $count = sizeof($url);
        $print->printLine('Total raw urls : ' . $count);

        if (!empty($count)) {
            foreach ($url as $urls) {
                if (pathinfo($urls[0], PATHINFO_EXTENSION) == 'pdf') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'zip') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'mp4') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'mp3') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'tar') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'jpg') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'png') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'gif') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == 'm4a') {
                    continue;
                } elseif (pathinfo($urls[0], PATHINFO_EXTENSION) == '3gp') {
                    continue;
                }
                if (!preg_match('/=/', $urls[0])) {
                    continue;
                }

                $urls[0] = str_replace('=', '=\'', $urls[0]);
                $print->printLine('Testing : ' . $urls[0]);
                $result = @file_get_contents($urls[0]);

                foreach (self::$sql as $sqli) {
                    if (preg_match('/' . $sqli . '/', $result)) {
                        $print->printSuccess('Hit (' . $sqli . ')');
                        $file = @fopen($filename, 'a');
                        if (!$file) {
                            $print->printWarning('warning can\'t write result');
                        } else {
                            fprintf($file, $urls[0] . PHP_EOL);
                            fclose($file);
                        }
                        break;
                    }
                }
            }
        } else {
            $print->printError('Can\'t continue, urls is empty');
        }
    }
}
