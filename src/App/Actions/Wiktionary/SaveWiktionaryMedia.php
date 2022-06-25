<?php

namespace RealMrHex\CrawlerCore\App\Actions\Wiktionary;

use RealMrHex\CrawlerCore\Base\ActionBase as Action;
use RealMrHex\CrawlerCore\Services\Storage;
use Symfony\Component\DomCrawler\Crawler;

class SaveWiktionaryMedia extends Action
{
    /**
     * Process the action
     * @return void
     */
    public function process(): void
    {
        $media_list = [];

        $media_urls = $this->storageItem('wiktionary_media');

        foreach ($media_urls as $media_url)
        {
            $page    = file_get_contents($media_url);
            $crawler = new Crawler($page);

            $dom_elements = $crawler->filter('div[class="fullImageLink"] > a > img');

            foreach ($dom_elements as $dom_element)
            {
                $path         = $dom_element->getAttribute("src");
                $final_path   = str_replace('//' , 'https://' , $path);
                $saved_path    = $this->_saveFile($final_path);

                $media_list[] = [
                    'path'  => $final_path,
                    'local' => $saved_path
                ];
            }

        }

        $this->temp['wiki_image_path'] = $media_list;

    }

    /**
     * File Saver Based on Kanji
     * @param $urll
     * @return string
     */
    private function _saveFile($url = null ): string
    {

        if(is_null($url))
        {
            $url = 'https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png';
        }

        $kanji = $this->getTargetKey();
        $file_name = basename($url );
        $extension = pathinfo($file_name , PATHINFO_EXTENSION);
        $file_dir  = getcwd() . '\\App\\' . 'Storage' . '\\kanjis\\' . $kanji . '\\';
        $file_path = $file_dir . $kanji . '.' . $extension;

        if( !file_exists( $file_dir ) ){
            mkdir( $file_dir , 6, true);
        }

        // get the file from url and save the file by using base name
        $save = file_put_contents( $file_path , file_get_contents($url) );

        return $save ? $file_path : '';
    }
}