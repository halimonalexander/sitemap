<?php
namespace HalimonAlexander\Sitemap;

class SitemapRegistrator
{
    /**
     * @param string[]             $filenames
     * @param AbstractSearchEngine $searchEngine
     *
     * @return string
     */
    public function registrate(array $filenames, AbstractSearchEngine $searchEngine): array
    {
        $response = [];
        
        foreach ($filenames as $filename) {
            $result = $searchEngine->pingEngine($filename) ? '%s: informed.' : '%s: error.';
            
            $response[] = sprintf($result, $searchEngine::NAME);
        }
    
        return $response;
    }
}
