<?php

namespace RealMrHex\CrawlerCore\Base;

use RealMrHex\CrawlerCore\Helpers\HasCrawlerBundle;
use RealMrHex\CrawlerCore\Helpers\HasPrettyName;
use RealMrHex\CrawlerCore\Helpers\Log;
use RealMrHex\CrawlerCore\Interfaces\IAction;
use RealMrHex\CrawlerCore\Services\DomCrawler;
use RealMrHex\CrawlerCore\Services\Storage;
use Symfony\Component\DomCrawler\Crawler;

abstract class ActionBase implements IAction
{
    use HasCrawlerBundle, HasPrettyName;

    /**
     * Bundle instance.
     * @var array
     */
    protected array $bundle;

    /**
     * Temp Data.
     * @var array
     */
    protected array $temp = [];

    /**
     * Action Name
     * @var string
     */
    protected string $name;

    /**
     * Define action data store status.
     * @var bool
     */
    protected bool $store = true;

    /**
     * Define action name in store result.
     * @var bool
     */
    protected bool $store_action_name = false;

    /**
     * Symfony DOMCrawler
     * @var Crawler
     */
    protected Crawler $crawler;

    /**
     * Return new action
     * @return $this
     */
    public static function new(): static
    {
        return new static();
    }

    /**
     * Return action name
     * @return $this
     */
    public static function name(): string
    {
        return (new static())->getName();
    }

    /**
     * Prepare action before process.
     * @param array $bundle
     * @return $this
     */
    public function prepare(array $bundle): void
    {
        $this->crawler = DomCrawler::singleton()->crawler();
        $this->bundle = $bundle;
    }

    /**
     * Store the action result
     * @return void
     */
    public function store(): void
    {
        if (!$this->store)
        {
            return;
        }

        $crawler = $this->getCrawlerName();
        $action = $this->getName(true);
        $data[$action] = $this->temp;
        $key = $this->getTargetKey();

        Log::write("[!] $key >>> Storing $crawler's $action Action data.", 'w');

        Storage::singleton()->addToList($crawler, $this->getTargetKey(), $this->store_action_name ? $data : $this->temp);

        Log::write("[√] $key >>> $crawler's $action Action data Stored.", 's');
    }

    /**
     * Get action name
     * @param bool $low
     * @return string
     */
    protected function getName(bool $low = false): string
    {
        $name = $this->name ?? $this->prettyName($low);
        return $low ? strtolower($name) : $name;
    }

    /**
     * Get current crawler storage
     * @return mixed
     */
    protected function storage(): mixed
    {
        return Storage::singleton()->getCrawlerData($this->getCrawlerName(), $this->getTargetKey());
    }

    /**
     * Get current crawler storage
     * @param string $item
     * @return mixed
     */
    protected function storageItem(string $item): mixed
    {
        return Storage::singleton()->getCrawlerDataByKeyItem($this->getCrawlerName(), $this->getTargetKey(), $item);
    }
}