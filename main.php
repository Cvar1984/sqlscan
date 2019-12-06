<?php
require __DIR__ . '/vendor/autoload.php';
use Cvar1984\SqlScan\SqlScan;
use Cvar1984\SqlScan\Cli;
use Serps\SearchEngine\Google\GoogleClient;
use Serps\HttpClient\CurlClient;
use Serps\SearchEngine\Google\GoogleUrl;
use Serps\Core\Browser\Browser;
use Serps\SearchEngine\Google\NaturalResultType;

try {
    $print = new Cli();
    $file  = file_get_contents('phar://main.phar/assets/banner.txt');
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
            $userAgent = "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36";
            $browserLanguage = "fr-FR";
            $browser = new Browser(new CurlClient(), $userAgent, $browserLanguage);
            $googleClient = new GoogleClient($browser);
            $googleUrl = new GoogleUrl();
            $googleUrl->setSearchTerm($argv[1]);
            $response = $googleClient->query($googleUrl);
            $results = $response->getNaturalResults();

            foreach ($results as $result) {
                if($result->is(NaturalResultType::CLASSICAL)){
                    $print->printLine('title : ' . $result->title);
                    $print->printLine('url : ' . $result->url);
                }

            }
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
