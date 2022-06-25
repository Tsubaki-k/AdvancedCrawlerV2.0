<?php

namespace RealMrHex\CrawlerCore\Interfaces;

interface IService
{
    /**
     * Return a new instance of service.
     * @return self
     */
    public static function singleton(): self;

    /**
     * Initialize the service.
     * @return static
     */
    public function init(): static;
}