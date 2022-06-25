<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class MainMeanings extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElement = $this->crawler->filter('div[class="kanji-details__main-meanings"]');
        $mainMeaning = explode(', ', trim($domElement->first()->getNode(0)->textContent));

        $this->temp['main_meaning'] = $mainMeaning;
    }
}