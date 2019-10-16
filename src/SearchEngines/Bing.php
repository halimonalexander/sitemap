<?php

namespace HalimonAlexander\Sitemap\SearchEngines;

use HalimonAlexander\Sitemap\AbstractSearchEngine;

class Bing extends AbstractSearchEngine
{
    public const NAME = 'Bing';
    
    protected $url = 'https://www.bing.com/webmaster/ping.aspx?siteMap=';
}
