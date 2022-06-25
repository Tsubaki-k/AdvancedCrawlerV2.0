<?php

namespace RealMrHex\CrawlerCore\App\Actions\Wiktionary;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;
use RealMrHex\CrawlerCore\Services\DomCrawler;

class FetchWiktionaryPage extends Action
{
    /**
     * Define action data store status.
     * @var bool
     */
    protected bool $store = false;

    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $storage = $this->storage();

        $url = $storage['external_link']['Wiktionary']['link'];

        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36');

        $page = file_get_contents($url);

        DomCrawler::singleton()->setPage($page);
    }
}