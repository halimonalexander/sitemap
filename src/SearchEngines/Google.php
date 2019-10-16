<?php

namespace HalimonAlexander\Sitemap\SearchEngines;

use HalimonAlexander\Sitemap\AbstractSearchEngine;

class Google extends AbstractSearchEngine
{
    public const NAME = 'Google';
    
    protected $url = 'https://google.com/webmasters/sitemaps/ping?sitemap=%s';
    protected $expectedResponse = 'successfully added';
}
