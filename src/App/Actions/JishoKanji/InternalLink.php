<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class InternalLink extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('ul[class="inline-list"] > li > a');

        $link_list = [];

        foreach ($domElements as $domElement){
            $link_list[] = [
                'link' => $domElement->getAttribute("href"),
                'name' => $domElement->textContent
            ];
        }

        $this->temp['internal_link'] = $link_list;
    }
}