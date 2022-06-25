<?php

namespace RealMrHex\CrawlerCore\Base;

use RealMrHex\CrawlerCore\Helpers\HasPrettyName;
use RealMrHex\CrawlerCore\Interfaces\IAction;
use RealMrHex\CrawlerCore\Interfaces\ICrawler;

abstract class CrawlerBase implements ICrawler
{
    use HasPrettyName;

    /**
     * Crawler name.
     * @var string
     */
    protected string $name;

    /**
     * Current url to crawl.
     * @var string
     */
    protected string $target_url;

    /**
     * Current key to crawl.
     * @var string
     */
    protected string $target_key;

    /**
     * Closed bundle instance.
     * @var array
     */
    protected array $bundle;

    /**
     * Define dynamic urls encoding status.
     * @var bool
     */
    protected bool $encode_dynamic_urls = false;

    /**
     * Generate new instance of crawler.
     * @return $this
     */
    public static function new(): static
    {
        return new static();
    }

    /**
     * Initialize the crawler
     * @return $this
     */
    public function init(): static
    {
        $this->name = $this->prettyName();

        return $this;
    }

    /**
     * Bundle for sending to actions
     * @return array
     */
    public function bundle(): array
    {
         $this->bundle['target']['url'] = $this->target_url;
         $this->bundle['target']['key'] = $this->target_key;
         $this->bundle['crawler']['name'] = strtolower($this->name);
         $this->bundle['crawler']['studly'] = $this->name;
         $this->bundle['crawler']['class'] = static::class;

        return $this->bundle;
    }

    /**
     * Run the crawler process.
     * @return void
     */
    public function crawl(): void
    {
        foreach ($this->_generatedUrls() as $generatedUrl)
        {
            $this->target_url = $generatedUrl['target'];
            $this->target_key = $generatedUrl['key'];
            $this->_fireActions();
        }
    }

    /**
     * Generate full list of urls.
     * @return array
     */
    private function _generatedUrls(): array
    {
        $base_url = $this->base_url();
        $dynamic_urls = $this->dynamic_urls();
        $_urls = [];

        foreach ($dynamic_urls as $key => $dynamic_url)
        {
            $tmp['key'] = $key;

            if ($this->encode_dynamic_urls)
            {
                if (is_array($dynamic_url))
                {
                    $dynamic_url_encoded = [];

                    foreach ($dynamic_url as $item)
                    {
                        $dynamic_url_encoded[] = urlencode($item);
                    }

                    $tmp['target'] = vsprintf($base_url, $dynamic_url_encoded);
                }
                else
                {
                    $tmp['target'] = sprintf($base_url, urlencode($dynamic_url));
                }
            }
            else
            {
                $tmp['target'] =  is_array($dynamic_url)
                    ? vsprintf($base_url, $dynamic_url)
                    : sprintf($base_url, $dynamic_url);
            }

            $_urls[] = $tmp;
        }

        return $_urls;
    }

    /**
     * Fire actions
     * @return void
     */
    private function _fireActions(): void
    {
        /**
         * @var array<IAction> $actions
         */
        $actions = $this->actions();

        foreach ($actions as $action)
        {
            $_action = $action::new();
            $_action->prepare($this->bundle());
            $_action->process();
            $_action->store();

        }
    }
}