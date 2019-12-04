<?php
namespace Cvar1984\SqlScan;

class Cli
{
    public function printStandar($var)
    {
        fprintf(STDOUT, '%s', $var);
    }
    public function printLine($var)
    {
        fprintf(STDOUT, '[#] %s%s', $var, PHP_EOL);
    }
    public function printWarning($var)
    {
        fprintf(STDERR, '[!] %s%s', $var, PHP_EOL);
    }
    public function printError($var)
    {
        throw new \Exception('[x] ' . $var);
    }
    public function printSuccess($var)
    {
        fprintf(STDOUT, '[+] %s%s', $var, PHP_EOL);
    }
    public function printFailed($var)
    {
        fprintf(STDOUT, '[-] %s%s', $var, PHP_EOL);
    }
    public function printAsk($var)
    {
        fprintf(STDOUT, '[?] %s%s', $var, PHP_EOL);
    }
}
