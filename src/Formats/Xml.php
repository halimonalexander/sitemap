<?php
namespace HalimonAlexander\Sitemap\Formats;

use HalimonAlexander\Sitemap\AbstractFormat;
use HalimonAlexander\Sitemap\Components\Url;

class Xml extends AbstractFormat
{
    public static function formatUrlItem(Url $url): string
    {
        $lines = [];
        $lines[] = '<url>';
        $lines[] = sprintf('  <loc>%s</loc>', $url->getUrl());
        if (($lastModified = $url->getLastModified()) !== null) {
            $lines[] = sprintf('  <lastmod>%s</lastmod>', $lastModified);
        }
        $lines[] = sprintf('  <changefreq>%s</changefreq>', $url->getChangeFrequency());
        $lines[] = sprintf('  <priority>%s</priority>', $url->getPriority());
        $lines[] = '</url>';
    
        return PHP_EOL . join(PHP_EOL, $lines) . PHP_EOL;
    }
    
    public static function formatWrapper(): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset',
            '    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"',
            '    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
            '    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9',
		    '        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">',
            '%s',
		    '</urlset>',
        ];
        
        return join(PHP_EOL, $lines);
    }
}
