# Sitemap
Sitemap plugin made using recomemdations from https://www.sitemaps.org/

Usage:
```
use \HalimonAlexander\Sitemap;
use \HalimonAlexander\Sitemap\SearchEngines;

$smg = new Sitemap\SitemapGenerator(Sitemap\SitemapGenerator::FORMAT_XML);

$smg->addUrl('http://example.com/');
$smg->addUrl('http://example.com/1&2', date('2019-07-01'));

$sitemaps = $smg->saveSitemap(__DIR__);

$smr = new Sitemap\SitemapRegistrator();
$results = array_merge(
    $smr->registrate($sitemaps, new SearchEngines\Bing()),
    $smr->registrate($sitemaps, new SearchEngines\Google()),
    $smr->registrate($sitemaps, new SearchEngines\Yandex())
);
echo join('<br>', $results);
```