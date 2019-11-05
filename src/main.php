<?php
require 'phar://main.phar/website_parser.php';
class Sqlscan extends WebsiteParser {
    private function println($var)
    {
        echo '[#] '.$var."\n";
    }
    function __construct($url) {
        $this->println('including config');
        $err=file_get_contents('phar://main.phar/sql.ini');
        $err=trim($err,',');
        $err=explode(',',$err);
        $parser=new WebsiteParser($url);
        $url=$parser->getHrefLinks();
        $count=sizeof($url);
        $this->println('Total urls: '.$count);

        if(!empty($count)) {
            foreach($url as $urls) {
                if(pathinfo($urls[0], PATHINFO_EXTENSION) =='pdf') {
                    continue;
                }
                elseif(pathinfo($urls[0], PATHINFO_EXTENSION) =='zip') {
                    continue;
                }
                elseif(pathinfo($urls[0], PATHINFO_EXTENSION) =='mp4') {
                    continue;
                }
                elseif(pathinfo($urls[0], PATHINFO_EXTENSION) =='mp3') {
                    continue;
                }
                elseif(pathinfo($urls[0], PATHINFO_EXTENSION) =='tar') {
                    continue;
                }

                if(!preg_match('/=/',$urls[0])) {
                    continue;
                }
                $urls[0]=str_replace('=','=\'',$urls[0]);
                $this->println('Testing '.$urls[0]);
                $result=@file_get_contents($urls[0]);

                foreach ($err as $errs) {
                    if(preg_match('/'.$errs.'/',$result)) {
                        $this->println('Vuln -> '.$urls[0]);
                        $file=fopen('result.txt','a');
                        fprintf($file,$urls[0]."\n");
                        fclose($file);
                        break;
                    }
                }
            }
        }
        else {
            throw new Exception("Can't continue, urls is empty\n");
            exit(1);
        }
    }
}
try {
    if($argc>=2) {
        $url=trim($argv[1]);
        if(filter_var($url, FILTER_VALIDATE_URL)) {
            $sql=new Sqlscan($url);
        }
        else {
            $pwd=getcwd().'/'.$url;
            if(file_exists($pwd)) {
                $file=file_get_contents($pwd);
                $file=trim($file, "\n");
                $url=explode("\n",$file);
                foreach ($url as $url) {
                    $sql=new Sqlscan($url);
                }
            }
            else {
                throw new Exception("File not exists $pwd\n");
                exit(1);
            }
        }
    }
    else {
        throw new Exception("Need argument, eg : sqlscan http://example.net\n");
    }
} catch(Exception $e) {
    echo $e->getMessage();
}
