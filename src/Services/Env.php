<?php

namespace RealMrHex\CrawlerCore\Services;

use Dotenv\Dotenv;
use RealMrHex\CrawlerCore\Base\ServiceBase as Service;
use RealMrHex\CrawlerCore\Helpers\Singleton;

class Env extends Service
{
    use Singleton;

    /**
     * Init the service
     * @return $this
     */
    public function init(): static
    {
        $env = Dotenv::createImmutable($this->_getEnvFilePath());
        $env->load();

        return $this;
    }

    /**
     * Get env file path
     * @return string
     */
    private function _getEnvFilePath(): string
    {
        return getcwd();
    }
}