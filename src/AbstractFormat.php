<?php

namespace HalimonAlexander\Sitemap;

use HalimonAlexander\Sitemap\Components\Url;

abstract class AbstractFormat
{
    abstract public static function formatUrlItem(Url $url): string;
    abstract public static function formatWrapper(): string;
}
