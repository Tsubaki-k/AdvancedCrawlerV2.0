<?php

namespace RealMrHex\CrawlerCore\Core;

use RealMrHex\CrawlerCore\Helpers\Log;
use RealMrHex\CrawlerCore\Helpers\Singleton;
use RealMrHex\CrawlerCore\Services\DomCrawler;
use RealMrHex\CrawlerCore\Services\Env;
use RealMrHex\CrawlerCore\Services\Storage;

class Engine
{
    use Singleton;

    protected array $services = [
        Env::class,
        Storage::class,
        DomCrawler::class,
    ];

    /**
     * Boot the engine
     * @return void
     */
    public function boot(): void
    {
        Log::write("[!] Booting the engine...", 'w');

        $this->_registerServices();

        $this->_initLogic();

        Log::write("[√] Engine Booted.", 's');

        $this->_run();
    }

    /**
     * Register the services
     * @return void
     */
    private function _registerServices(): void
    {
        Log::write("[!] Registering the services...", 'w');

        foreach ($this->services as $service)
        {
            Env::singleton()->init();
            $_serviceInstance = call_user_func($service . '::singleton');
            $_serviceInstance
                ->registering()
                ->init()
                ->registered();
        }

        Log::write("[√] Services registered.", 's');
    }

    /**
     * Init Application logic
     * @return void
     */
    private function _initLogic(): void
    {
        Log::write("[!] Initializing the logic...", 'w');

        include_once getcwd() . '/App/logic.php';

        Log::write("[√] Logic initialized.", 's');
    }

    /**
     * Run the application
     * @return void
     */
    private function _run(): void
    {
        Log::write("[+] Application is running...");

        $start = time();

        LogicManager::singleton()->run();

        $diff = time() - $start;

        Log::write("[+] Process finished. [$diff secs]", 's');
    }
}