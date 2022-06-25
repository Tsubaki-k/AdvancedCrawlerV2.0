<?php

namespace RealMrHex\CrawlerCore\Helpers;

trait Singleton
{
    /**
     * Lock the constructor.
     */
    private function __construct() {}

    /**
     * Lock the clone.
     * @return void
     */
    private function __clone(): void {}

    /**
     * Class instance.
     */
    private static mixed $_instance = null;

    /**
     * Get a singleton instance
     * @return self
     */
    public static function singleton(): self
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}