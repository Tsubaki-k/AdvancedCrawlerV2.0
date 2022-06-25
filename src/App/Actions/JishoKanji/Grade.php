<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class Grade extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElement = $this->crawler->filter('div[class="kanji_stats"] > div[class="grade"]');
        $details = explode('taught in', $domElement->getNode(0)->textContent);

        $this->temp['grade'] = [
            'type'  => trim(str_replace(', taught in', '', $details[0])),
            'level' => trim($details[1])
        ];
    }
}