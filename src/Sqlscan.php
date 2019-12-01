<?php
namespace Cvar\Sqlscan;

class Sqlscan  {
    private function println($var)
    {
        fprintf(STDOUT, '[#] %s%s', $var, PHP_EOL);
    }
    function __construct($url)
    {
        $this->println('including config');
        $err = file_get_contents('phar://main.phar/sql.ini');
        $err = trim($err, ',');
        $err = explode(',', $err);
        $this->println('extracting links');
        $parser = new \Cvar\Sqlscan\WebsiteParser($url);
        $url = $parser->getHrefLinks();
        $count = sizeof($url);
        $this->println('Total raw urls : ' . $count);

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
                $this->println('injecting magic char');
                $urls[0] = str_replace('=', '=\'', $urls[0]);
                $this->println('Testing : ' . $urls[0]);
                $result = @file_get_contents($urls[0]);

                foreach ($err as $errs) {
                    if (preg_match('/' . $errs . '/', $result)) {
                        $this->println('Vuln -> ' . $urls[0]);
                        $file = @fopen('result.txt', 'a');
                        if(!$file) {
                            $this->println('warning can\'t write result');
                        }
                        else {
                            fprintf($file, $urls[0] . PHP_EOL);
                            fclose($file);
                        }
                        break;
                    }
                }
            }
        } else {
            throw new \Exception("Can't continue, urls is empty");
        }
    }
}

