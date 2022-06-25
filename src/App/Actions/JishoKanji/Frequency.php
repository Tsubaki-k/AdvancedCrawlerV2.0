<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class Frequency extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElement = $this->crawler->filter('div[class="kanji_stats"] > div[class="frequency"]');
        $details = explode('of', $domElement->getNode(0)->textContent);

        $this->temp['frequency'] = [
            'position'  => trim($details[0]),
            'frequency' => 'of ' . trim($details[1])
        ];
    }
}