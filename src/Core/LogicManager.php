<?php

namespace RealMrHex\CrawlerCore\Core;

use RealMrHex\CrawlerCore\Helpers\Singleton;
use RealMrHex\CrawlerCore\Interfaces\ICrawler;
use RealMrHex\CrawlerCore\Services\Storage;

class LogicManager
{
    use Singleton;

    /**
     * Run the logics
     * @return void
     */
    public function run(): void
    {
        /**
         * @var array<ICrawler> $crawlers
         */
        $crawlers = Storage::singleton()->get('logic');

        foreach ($crawlers as $crawler)
        {
            $crawler::new()->init()->crawl();
        }
    }
}