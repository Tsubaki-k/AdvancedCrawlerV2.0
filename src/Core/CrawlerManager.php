<?php

namespace RealMrHex\CrawlerCore\Core;

use RealMrHex\CrawlerCore\Services\Storage;

class CrawlerManager
{
    /**
     * Register new crawler
     * @param string $crawler
     * @return void
     */
    public static function register(string $crawler): void
    {
        Storage::singleton()->addToList('logic', '', $crawler);
    }
}