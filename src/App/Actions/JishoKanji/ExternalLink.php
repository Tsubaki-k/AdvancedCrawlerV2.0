<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class ExternalLink extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('a[class="external"]');

        $link_list = [];

        foreach ($domElements as $domElement){
            $textContent = $domElement->textContent;
            $link_list[$textContent] = [
                'name' => $textContent,
                'link' => $domElement->getAttribute("href"),
            ];
        }

        $this->temp['external_link'] = $link_list;
    }
}