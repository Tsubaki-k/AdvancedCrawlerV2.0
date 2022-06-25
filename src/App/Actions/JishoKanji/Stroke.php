<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class Stroke extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElement = $this->crawler->filter('div[class="kanji-details__stroke_count"]');
        $details = explode('strokes', $domElement->getNode(0)->textContent);
        $this->temp['stroke'] = trim($details[0]);
    }
}