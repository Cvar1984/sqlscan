<?php

namespace Cvar1984\SqlScan;

use Cvar1984\SqlScan\Cli as Cout;

class SqlScan
{
    protected static array $sqlList;
    protected static array $bannedExtension;

    public function __construct()
    {
        // setup
        $sql = file_get_contents('phar://main.phar/assets/sql.ini');
        if (!$sql) {
            Cout::printError('Sql word not found');
        }

        Cout::printSuccess('Sql word included');
        $sql = trim($sql, ',');
        self::$sqlList = explode(',', $sql);
        self::$bannedExtension = [
            'pdf',
            'zip',
            'mp3',
            'mp4',
            '3gp',
            'jpg',
            'png',
            'gif',
            'iso',
            'gz',
            'rar',
        ];
    }

    public function scan(string $url, string $filename) : void
    {
        $parser = new \Cvar1984\SqlScan\WebsiteParser($url);
        if (empty($url)) {
            Cout::printError('Please insert url');
        }

        Cout::printLine('Extracting : ' . $url);
        $url = $parser->getHrefLinks();
        $count = sizeof($url);
        Cout::printLine('Total raw urls : ' . $count);

        if (!empty($count)) {
            $urlz = [];
            foreach ($url as $urls) {
                $urlExtension = pathinfo($urls[0], PATHINFO_EXTENSION);
                if (in_array($urlExtension, self::$bannedExtension)) {
                    continue;
                }
                if (!preg_match('/=/', $urls[0])) {
                    continue;
                }
                $urlz[] = $urls[0];
            }
            $count = count($urlz);
            $progressBar = new \ProgressBar\Manager(0, $count);
            Cout::printLine('Total available urls : ' . $count);
            foreach ($urlz as $urls) {
                $urls = str_replace('=', '=\'', $urls);
                Cout::printStandar('Scanning ');
                $progressBar->advance();
                $result = @file_get_contents($urls);

                foreach (self::$sqlList as $sqli) {
                    if (preg_match('/' . $sqli . '/Usi', $result)) {
                        Cout::printSuccess('Hit (' . $sqli . ')');
                        Cout::printSuccess('Url (' . $urls . ')');

                        $file = @fopen($filename, 'a');
                        if (!$file) {
                            Cout::printWarning('warning can\'t write result');
                        } else {
                            fprintf($file, $urls . PHP_EOL);
                            fclose($file);
                            Cout::printSuccess('Saved (' . $filename . ')');
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
