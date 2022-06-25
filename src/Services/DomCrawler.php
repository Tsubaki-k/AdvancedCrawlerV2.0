<?php

namespace RealMrHex\CrawlerCore\Services;

use RealMrHex\CrawlerCore\Base\ServiceBase as Service;
use RealMrHex\CrawlerCore\Helpers\Singleton;
use Symfony\Component\DomCrawler\Crawler;

class DomCrawler extends Service
{
    use Singleton;

    /**
     * DomCrawler
     * @var Crawler $crawler
     */
    public Crawler $crawler;

    /**
     * Initialize the service
     * @return $this
     */
    public function init(): static
    {
        $this->crawler = new Crawler();
        return $this;
    }

    /**
     * Set crawler page
     * @param string $page
     * @return void
     */
    public function setPage(string $page): void
    {
        $this->crawler = new Crawler($page);
    }

    /**
     * Get the crawler
     * @return Crawler
     */
    public function crawler(): Crawler
    {
        return $this->crawler;
    }
}