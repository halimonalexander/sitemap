<?php
namespace HalimonAlexander\Sitemap\Formats;

use HalimonAlexander\Sitemap\AbstractFormat;
use HalimonAlexander\Sitemap\Components\Url;

class Text extends AbstractFormat
{
     public static function formatUrlItem(Url $url): string
     {
         return $url->getUrl();
     }
     
     public static function formatWrapper(): string
     {
         return '%s';
     }
}
