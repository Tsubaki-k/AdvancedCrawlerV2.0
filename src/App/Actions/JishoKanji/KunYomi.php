<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class KunYomi extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('div[class="kanji-details__main-readings"] > dl[class="dictionary_entry kun_yomi"] > dd > a');

        $kun_list = [];

        foreach ($domElements as $domElement)
        {
            $kun_list[] = $domElement->textContent;
        }

        $this->temp['kun_yomi'] = $kun_list;
    }
}