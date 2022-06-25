<?php

namespace RealMrHex\CrawlerCore\App\Actions\JishoKanji;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;

class KunYomiVocabs extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $domElements = $this->crawler->filter('div[class="small-12 large-6 columns"]:nth-of-type(2) > ul > li');

        $link_list = [];

        foreach ($domElements as $domElement){

            $_content = $domElement->textContent;
            $_replacer = str_replace(["【" , "】"],"-", $_content);
            $_exploder_vocab = explode('-', $_replacer);
            $exploder_meaning = explode( ',' , $_exploder_vocab[2] );

            $link_list[] = [
                'word'    => $_exploder_vocab[0],
                'kana'    => $_exploder_vocab[1],
                'meaning' => $exploder_meaning,
            ];

        }

        $this->temp['kunyomi_vocabs'] = $link_list;
    }
}