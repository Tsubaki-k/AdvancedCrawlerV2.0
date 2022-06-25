<?php

namespace RealMrHex\CrawlerCore\Helpers;

class Log
{
    /**
     * Write log
     * @param string $str
     * @param string $type
     * @return void
     */
    public static function write(string $str, string $type = 'i')
    {
        echo match ($type)
        {
            'e'     => "\033[31m$str \033[0m\n",
            's'     => "\033[32m$str \033[0m\n",
            'w'     => "\033[33m$str \033[0m\n",
            default => "\033[36m$str \033[0m\n",
        };
    }

    /**
     * Register service log
     * @param string $serviceName
     * @return void
     */
    public static function serviceRegistering(string $serviceName): void
    {
        self::write("[!] Registering $serviceName.", 'w');
    }

    /**
     * Register service log
     * @param string $serviceName
     * @return void
     */
    public static function serviceRegistered(string $serviceName): void
    {
        self::write("[√] Registered $serviceName.", 's');
    }
}