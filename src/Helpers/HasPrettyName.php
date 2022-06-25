<?php

namespace RealMrHex\CrawlerCore\Helpers;

trait HasPrettyName
{
    /**
     * Get pretty class name.
     * @param bool $low
     * @return string
     */
    private function prettyName(bool $low = false): string
    {
        $name = basename(str_replace('\\', '/', get_class($this)));

        return $low ? strtolower($name) : $name;
    }
}