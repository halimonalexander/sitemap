<?php

namespace HalimonAlexander\Sitemap\SearchEngines;

use HalimonAlexander\Sitemap\AbstractSearchEngine;

class Yandex extends AbstractSearchEngine
{
    public const NAME = 'Yandex';
    
    protected $expectedResponse = 'OK';
    protected $url = 'https://blogs.yandex.ru/pings/?status=success&url=%s';
}
