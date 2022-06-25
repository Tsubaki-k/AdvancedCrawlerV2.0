<?php

namespace RealMrHex\CrawlerCore\App\Crawlers;

use RealMrHex\CrawlerCore\App\Actions\JishoKanji\ExternalLink;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\Frequency;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\Grade;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\InternalLink;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\JLPT;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\KunYomi;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\KunYomiVocabs;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\MainMeanings;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\OnYomi;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\OnYomiVocabs;
use RealMrHex\CrawlerCore\App\Actions\JishoKanji\Stroke;
use RealMrHex\CrawlerCore\App\Actions\Shared\FetchPageByFileGetContents;
use RealMrHex\CrawlerCore\App\Actions\Wiktionary\FetchWiktionaryPage;
use RealMrHex\CrawlerCore\App\Actions\Wiktionary\SaveWiktionaryMedia;
use RealMrHex\CrawlerCore\App\Actions\Wiktionary\WiktionaryMedia;
use RealMrHex\CrawlerCore\Base\CrawlerBase as Crawler;
use RealMrHex\CrawlerCore\Interfaces\IAction;

class KanjiCrawler extends Crawler
{
    /**
     * Define dynamic urls encoding status.
     * @var bool
     */
    protected bool $encode_dynamic_urls = true;

    /**
     * Base url
     * @return string
     */
    public function base_url(): string
    {
        return 'https://jisho.org/search/%s';
    }

    /**
     * Bundle for sending to actions
     * @return array
     */
    public function bundle(): array
    {
        $this->bundle['wiktionary']['base'] = 'https://en.wiktionary.org';
        return parent::bundle();
    }

    /**
     * Dynamic parts of url
     * @return array
     */
    public function dynamic_urls(): array
    {
        return [
            '一' => '一 #kanji' ,
            '七' => '七 #kanji' ,
            '万' => '万 #kanji' ,
            '三' => '三 #kanji' ,
            '上' => '上 #kanji' ,
            '下' => '下 #kanji' ,
            '中' => '中 #kanji' ,
            '九' => '九 #kanji' ,
            '二' => '二 #kanji' ,
            '五' => '五 #kanji' ,
            '人' => '人 #kanji' ,
            '今' => '今 #kanji' ,
            '休' => '休 #kanji' ,
            '会' => '会 #kanji' ,
            '何' => '何 #kanji' ,
            '先' => '先 #kanji' ,
            '入' => '入 #kanji' ,
            '八' => '八 #kanji' ,
            '六' => '六 #kanji' ,
            '円' => '円 #kanji' ,
            '出' => '出 #kanji' ,
            '分' => '分 #kanji' ,
            '前' => '前 #kanji' ,
            '北' => '北 #kanji' ,
            '十' => '十 #kanji' ,
            '千' => '千 #kanji' ,
            '午' => '午 #kanji' ,
            '半' => '半 #kanji' ,
            '南' => '南 #kanji' ,
            '友' => '友 #kanji' ,
            '口' => '口 #kanji' ,
            '古' => '古 #kanji' ,
            '右' => '右 #kanji' ,
            '名' => '名 #kanji' ,
            '四' => '四 #kanji' ,
            '国' => '国 #kanji' ,
            '土' => '土 #kanji' ,
            '外' => '外 #kanji' ,
            '多' => '多 #kanji' ,
            '大' => '大 #kanji' ,
            '天' => '天 #kanji' ,
            '女' => '女 #kanji' ,
            '子' => '子 #kanji' ,
            '学' => '学 #kanji' ,
            '安' => '安 #kanji' ,
            '小' => '小 #kanji' ,
            '少' => '少 #kanji' ,
            '山' => '山 #kanji' ,
            '川' => '川 #kanji' ,
            '左' => '左 #kanji' ,
            '年' => '年 #kanji' ,
            '店' => '店 #kanji' ,
            '後' => '後 #kanji' ,
            '手' => '手 #kanji' ,
            '新' => '新 #kanji' ,
            '日' => '日 #kanji' ,
            '時' => '時 #kanji' ,
            '書' => '書 #kanji' ,
            '月' => '月 #kanji' ,
            '木' => '木 #kanji' ,
            '本' => '本 #kanji' ,
            '来' => '来 #kanji' ,
            '東' => '東 #kanji' ,
            '校' => '校 #kanji' ,
            '母' => '母 #kanji' ,
            '毎' => '毎 #kanji' ,
            '気' => '気 #kanji' ,
            '水' => '水 #kanji' ,
            '火' => '火 #kanji' ,
            '父' => '父 #kanji' ,
            '生' => '生 #kanji' ,
            '男' => '男 #kanji' ,
            '白' => '白 #kanji' ,
            '百' => '百 #kanji' ,
            '目' => '目 #kanji' ,
            '社' => '社 #kanji' ,
            '空' => '空 #kanji' ,
            '立' => '立 #kanji' ,
            '耳' => '耳 #kanji' ,
            '聞' => '聞 #kanji' ,
            '花' => '花 #kanji' ,
            '行' => '行 #kanji' ,
            '西' => '西 #kanji' ,
            '見' => '見 #kanji' ,
            '言' => '言 #kanji' ,
            '話' => '話 #kanji' ,
            '語' => '語 #kanji' ,
            '読' => '読 #kanji' ,
            '買' => '買 #kanji' ,
            '足' => '足 #kanji' ,
            '車' => '車 #kanji' ,
            '週' => '週 #kanji' ,
            '道' => '道 #kanji' ,
            '金' => '金 #kanji' ,
            '長' => '長 #kanji' ,
            '間' => '間 #kanji' ,
            '雨' => '雨 #kanji' ,
            '電' => '電 #kanji' ,
            '食' => '食 #kanji' ,
            '飲' => '飲 #kanji' ,
            '駅' => '駅 #kanji' ,
            '高' => '高 #kanji' ,
            '魚' => '魚 #kanji' ,
        ];
    }

    /**
     * Actions.
     * @return array<IAction>
     */
    public function actions(): array
    {
        return [
            FetchPageByFileGetContents::class,
            Stroke::class,
            KunYomi::class,
            OnYomi::class,
            MainMeanings::class,
            Grade::class,
            JLPT::class,
            Frequency::class,
            InternalLink::class,
            ExternalLink::class,
            KunYomiVocabs::class,
            OnYomiVocabs::class,
            FetchWiktionaryPage::class,
            WiktionaryMedia::class,
            SaveWiktionaryMedia::class,
        ];
    }
}