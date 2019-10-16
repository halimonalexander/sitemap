<?php

namespace HalimonAlexander\Sitemap;

class AbstractSearchEngine
{
    protected $expectedResponse = null;
    protected $url = null;
    
    /**
     * @param string $sitemapFilename
     *
     * @return bool
     */
    public function pingEngine(string $sitemapFilename): bool
    {
        return $this->pingUrl($this->url . urlencode($sitemapFilename));
    }
    
    /**
     * @param string $url
     *
     * @return bool
     */
    private function pingUrl(string $url): bool
    {
        $result = $this->getPingResponse($url);
        if ($this->expectedResponse === null) {
            return true;
        }
        
        if ($result === null || strpos($result, $this->expectedResponse) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param $url
     *
     * @return null|string
     */
    private function getPingResponse(string $url): ?string
    {
        if (!function_exists('curl_init')) {
            return @file_get_contents($url) ?: null;
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
        
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data ?: null;
    }
}
