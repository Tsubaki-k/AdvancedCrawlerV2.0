<?php

namespace RealMrHex\CrawlerCore\Base;

use RealMrHex\CrawlerCore\Helpers\HasPrettyName;
use RealMrHex\CrawlerCore\Helpers\Log;
use RealMrHex\CrawlerCore\Interfaces\IService;

abstract class ServiceBase implements IService
{
    use HasPrettyName;

    /**
     * Notify that the service registered.
     * @return void
     */
    public function registered(): void
    {
        Log::serviceRegistered($this->prettyName());
    }

    /**
     * Notify that the service is registering.
     * @return self
     */
    public function registering(): self
    {
        Log::serviceRegistering($this->prettyName());

        return $this;
    }
}