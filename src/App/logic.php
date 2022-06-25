<?php

use RealMrHex\CrawlerCore\App\Crawlers\KanjiCrawler;
use RealMrHex\CrawlerCore\Core\CrawlerManager;

/**
 * =======================================================
 *
 *           ADD CRAWLERS TO THE APPLICATION
 *         [NOTICE] ORDER IS IMPORTANT [NOTICE]
 *
 *
 */

CrawlerManager::register(KanjiCrawler::class);





