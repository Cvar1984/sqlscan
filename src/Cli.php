<?php
namespace Cvar1984\SqlScan;

class Cli
{
    protected static $black = "\033[0;30m";
    protected static $dark_gray = "\033[1;30m";
    protected static $blue = "\033[0;34m";
    protected static $light_blue = "\033[1;34m";
    protected static $green = "\033[0;32m";
    protected static $light_green = "\033[1;32m";
    protected static $cyan = "\033[0;36m";
    protected static $light_cyan = "\033[1;36m";
    protected static $red = "\033[0;31m";
    protected static $light_red = "\033[1;31m";
    protected static $purple = "\033[0;35m";
    protected static $light_purple = "\033[1;35m";
    protected static $brown = "\033[0;33m";
    protected static $yellow = "\033[1;33m";
    protected static $light_gray = "\033[0;37m";
    protected static $white = "\033[1;0m";

    public static function printStandar($var)
    {
        fprintf(STDOUT, '%s', $var);
    }
    public static function printLine($var)
    {
        fprintf(
            STDOUT,
            '%s[#]%s %s%s',
            self::$light_cyan,
            self::$white,
            $var,
            PHP_EOL
        );
    }
    public static function printWarning($var)
    {
        fprintf(
            STDERR,
            '%s[!]%s %s%s',
            self::$light_red,
            self::$white,
            $var,
            PHP_EOL
        );
    }
    public static function printError($var)
    {
        throw new \Exception(self::$red . '[x] ' . self::$white . $var);
    }
    public static function printSuccess($var)
    {
        fprintf(
            STDOUT,
            '%s[+]%s %s%s',
            self::$light_green,
            self::$white,
            $var,
            PHP_EOL
        );
    }
    public static function printFailed($var)
    {
        fprintf(
            STDOUT,
            '%s[-]%s %s%s',
            self::$light_red,
            self::$white,
            $var,
            PHP_EOL
        );
    }
    public static function printAsk($var)
    {
        fprintf(
            STDOUT,
            '%s[?]%s %s%s',
            self::$yellow,
            self::$white,
            $var,
            PHP_EOL
        );
    }
}
