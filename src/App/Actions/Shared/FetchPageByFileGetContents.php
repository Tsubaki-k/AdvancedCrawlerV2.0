<?php

namespace RealMrHex\CrawlerCore\App\Actions\Shared;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;
use RealMrHex\CrawlerCore\Services\DomCrawler;

class FetchPageByFileGetContents extends Action
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
        $this->getTargetUrl();
        $page = file_get_contents($this->getTargetUrl());

        DomCrawler::singleton()->setPage($page);
    }
}