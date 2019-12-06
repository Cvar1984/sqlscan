<?php
namespace Cvar1984\SqlScan;

class Cli
{
    public static function printStandar($var)
    {
        fprintf(STDOUT, '%s', $var);
    }
    public static function printLine($var)
    {
        fprintf(STDOUT, '[#] %s%s', $var, PHP_EOL);
    }
    public static function printWarning($var)
    {
        fprintf(STDERR, '[!] %s%s', $var, PHP_EOL);
    }
    public static function printError($var)
    {
        throw new \Exception('[x] ' . $var);
    }
    public static function printSuccess($var)
    {
        fprintf(STDOUT, '[+] %s%s', $var, PHP_EOL);
    }
    public static function printFailed($var)
    {
        fprintf(STDOUT, '[-] %s%s', $var, PHP_EOL);
    }
    public static function printAsk($var)
    {
        fprintf(STDOUT, '[?] %s%s', $var, PHP_EOL);
    }
}
