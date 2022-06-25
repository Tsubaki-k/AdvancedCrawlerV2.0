<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class OnYomi extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('div[class="kanji-details__main-readings"] > dl[class="dictionary_entry on_yomi"] > dd > a');

        $on_list = [];

        foreach ($domElements as $domElement){
            $on_list[] = $domElement->textContent;
        }

        $this->temp['on_yomi'] = $on_list;
    }
}