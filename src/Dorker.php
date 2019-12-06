<?php
namespace Cvar1984\SqlScan;
use Serps\SearchEngine\Google\GoogleClient;
use Serps\HttpClient\CurlClient;
use Serps\SearchEngine\Google\GoogleUrl;
use Serps\Core\Browser\Browser;
use Serps\SearchEngine\Google\NaturalResultType;
use Cvar1984\SqlScan\Cli;
class Dorker
{
    protected static $userAgent = "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36";
    protected static $browserLanguage = "fr-FR";
    protected static $error=null;
    function __construct(string $dork, string $filename='result_url.txt')
    {
        $browser = new Browser(new CurlClient(), self::$userAgent, self::$browserLanguage);
        $googleClient = new GoogleClient($browser);
        $googleUrl = new GoogleUrl();
        $googleUrl->setSearchTerm($dork);
        $response = $googleClient->query($googleUrl);
        $results = $response->getNaturalResults();

        foreach ($results as $result) {
            if($result->is(NaturalResultType::CLASSICAL)){
                Cli::printLine('title : ' . $result->title);
                Cli::printLine('url : ' . $result->url);
                $write=@fopen($filename, 'a');
                if($write) {
                    fprintf($write, '%s%s', $result->url, PHP_EOL);
                    fclose($write);
                }
                else {
                    self::$error='Waring can\'t write result';
                }
            }
        }
        if(!empty(self::$error)) {
            Cli::printWarning(self::$error);
        }
    }
}
