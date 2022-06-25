<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class JLPT extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElement = $this->crawler->filter('div[class="kanji_stats"] > div[class="jlpt"]');
        $details = explode('level', $domElement->getNode(0)->textContent);

        $this->temp['jlpt'] = [
            'position'  => trim($details[0]),
            'frequency' => trim($details[1])
        ];
    }
}