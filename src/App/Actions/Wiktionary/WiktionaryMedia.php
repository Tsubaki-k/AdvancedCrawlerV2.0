<?php

namespace RealMrHex\CrawlerCore\App\Actions\Wiktionary;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class WiktionaryMedia extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('table[class="floatright wikitable"] a[class="image"]');
        $base_url = $this->getBundleItem('wiktionary')['base'];


        $media = [];
        foreach ($domElements as $domElement)
        {
            $path =  $base_url . $domElement->getAttribute("href");
            $media[] = $path;
        }

        $this->temp['wiktionary_media'] =  $media;
    }
}