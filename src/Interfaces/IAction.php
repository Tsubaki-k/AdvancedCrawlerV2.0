<?php

namespace RealMrHex\CrawlerCore\Interfaces;

interface IAction
{
    /**
     * Prepare action before process.
     * @param array $bundle
     * @return void
     */
    public function prepare(array $bundle): void;

    /**
     * Process the action
     * @return void
     */
    public function process(): void;

    /**
     * Store the action result
     * @return void
     */
    public function store(): void;
}