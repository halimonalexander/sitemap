<?php
namespace HalimonAlexander\Sitemap;

use HalimonAlexander\Sitemap\Formats\Text;
use HalimonAlexander\Sitemap\Formats\Xml;
use http\Exception\RuntimeException;

/**
 * Class SitemapGenerator
 *
 * @copyright Copyright (c) 2013-2019
 * @author    A.Halimon <vvthanatos@gmail.com>
 */
class SitemapGenerator
{
    public const USE_COMPRESSION = true;
    public const ITEMS_PER_FILE = 50000;
    
    public const FORMAT_TEXT = 'text';
    public const FORMAT_XML = 'xml';
    
    /**
     * @var string
     */
    private $format;
    
    /**
     * @var Components\Url[]
     */
    protected $urls = [];
    
    public function __construct(string $format)
    {
        $availableFormats = [
            self::FORMAT_TEXT,
            self::FORMAT_XML,
        ];
        
        if (!in_array($format, $availableFormats)) {
            throw new \RuntimeException('Format not supported');
        }
        
        $this->format = $format;
    }
    
    /**
     * Add url to sitemap
     *
     * @param string $url
     * @param string $lastModified
     * @param string $changeFrequency
     * @param float  $priority
     *
     * @return void
     */
    public function addUrl(
        string $url,
        string $lastModified = null,
        string $changeFrequency = Components\Url::CHANGE_FREQUENCY_WEEKLY,
        float $priority = 0.8
    ): void
    {
        $this->urls[] = new Components\Url($url, $lastModified, $changeFrequency, $priority);
    }
    
    /**
     * Assemble and save sitemap(s) to disk
     *
     * @param string $path
     *
     * @return string[]
     */
    public function saveSitemap(string $path): array
    {
        $response = [];
        $filesQuantity = floor(count($this->urls) / static::ITEMS_PER_FILE) + 1;
        for ($i = 0; $i < $filesQuantity; $i++) {
            if (count($this->urls) > static::ITEMS_PER_FILE) {
                $urls = array_slice($this->urls, $i * static::ITEMS_PER_FILE, static::ITEMS_PER_FILE);
                $content = $this->assembleSitemap($urls);
            } else {
                $content = $this->assembleSitemap();
            }
            
            if (static::USE_COMPRESSION) {
                $this->compress($content);
            }
            
            $response[] = $filename = $i === 0 ? 'sitemap.xml' : "sitemap-{$i}.xml";
            
            $path = rtrim($path, DIRECTORY_SEPARATOR);
            
            file_put_contents($path . DIRECTORY_SEPARATOR . $filename, $content);
        }
        
        return $response;
    }
    
    /**
     * @param array|null $urls
     *
     * @return string
     */
    private function assembleSitemap(array $urls = null)
    {
        if ($urls === null)
            $urls = $this->urls;
        
        $wrapper = $this->getFormatter()::formatWrapper();
        $urls = implode(PHP_EOL, $this->formatUrls($urls));
        
        return sprintf($wrapper, $urls);
    }
    
    /**
     * @param Components\Url[] $urls
     *
     * @return string[]
     */
    private function formatUrls(array $urls): array
    {
        foreach ($urls as $url) {
            $response[] = $this->getFormatter()::formatUrlItem($url);
        }
        
        return $response;
    }
    
    /**
     * @param string $content
     */
    private function compress(string &$content): void
    {
        $content = str_replace(["\r", "\n"], ["", ""], $content);
        $content = str_replace("  ", " ", $content);
        $content = str_replace("> <", "><", $content);
    }
    
    private function getFormatter(): string
    {
        switch ($this->format) {
            case self::FORMAT_TEXT:
                return Text::class;
                break;
            case self::FORMAT_XML:
                return Xml::class;
                break;
        }
    }
}
