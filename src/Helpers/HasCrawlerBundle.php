<?php

namespace RealMrHex\CrawlerCore\Helpers;

trait HasCrawlerBundle
{
    /**
     * Get crawler name.
     * @return string
     */
    protected function getCrawlerName(): string
    {
        return $this->bundle['crawler']['name'];
    }

    /**
     * Get target url.
     * @return string
     */
    protected function getTargetUrl(): string
    {
        return $this->bundle['target']['url'];
    }

    /**
     * Get target url.
     * @return string
     */
    protected function getTargetKey(): string
    {
        return $this->bundle['target']['key'];
    }

    /**
     * Get item from bundle
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getBundleItem(string $key, mixed $default = ''): mixed
    {
        return $this->bundle[$key] ?? $default;
    }
}