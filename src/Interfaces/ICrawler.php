<?php

namespace RealMrHex\CrawlerCore\Interfaces;

interface ICrawler
{
    /**
     * Base url
     * @return string
     */
    public function base_url(): string;

    /**
     * Dynamic parts of url
     * @return array
     */
    public function dynamic_urls(): array;

    /**
     * Actions.
     * @return array<IAction>
     */
    public function actions(): array;

    /**
     * Bundle for sending to actions
     * @return array
     */
    public function bundle(): array;

    /**
     * Initialize the crawler.
     * @return $this
     */
    public function init(): static;

    /**
     * Run the crawler process.
     * @return void
     */
    public function crawl(): void;
}