<?php
namespace HalimonAlexander\Sitemap\Components;

class Url
{
    public const CHANGE_FREQUENCY_ALWAYS = 'always';
    public const CHANGE_FREQUENCY_HOURLY = 'hourly';
    public const CHANGE_FREQUENCY_DAILY = 'daily';
    public const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    public const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    public const CHANGE_FREQUENCY_YEARLY = 'yearly';
    public const CHANGE_FREQUENCY_NEVER = 'never';

    private $changeFrequency;
    /**
     * @var \DateTime
     */
    private $lastModified;
    private $priority;
    private $url;
    
    public function __construct(
        string $url,
        ?string $lastModified,
        string $changeFrequency = self::CHANGE_FREQUENCY_WEEKLY,
        float $priority = 0.8
    ) {
        $this->setUrl($url);
        $this->setLastModified($lastModified);
        $this->setChangeFrequency($changeFrequency);
        $this->setPriority($priority);
    }
    
    public function getChangeFrequency(): string
    {
        return $this->changeFrequency;
    }
    
    private function setChangeFrequency(string $changeFrequency)
    {
        $allowedValues = [
            self::CHANGE_FREQUENCY_ALWAYS,
            self::CHANGE_FREQUENCY_HOURLY,
            self::CHANGE_FREQUENCY_DAILY,
            self::CHANGE_FREQUENCY_WEEKLY,
            self::CHANGE_FREQUENCY_MONTHLY,
            self::CHANGE_FREQUENCY_YEARLY,
            self::CHANGE_FREQUENCY_NEVER,
        ];
        if (!in_array($changeFrequency, $allowedValues)) {
            // add warning notification
            
            $changeFrequency = self::CHANGE_FREQUENCY_MONTHLY;
        }
        
        $this->changeFrequency = $changeFrequency;
    }
    
    public function getLastModified($format = "Y-m-d"): ?string
    {
        if ($this->lastModified === null) {
            return null;
        }
        
        return $this->lastModified->format($format);
    }
    
    private function setLastModified(?string $lastModified)
    {
        if ($lastModified === null) {
            $this->lastModified = null;
            return;
        }
        
        try {
            $this->lastModified = new \DateTime($lastModified);
        } catch (\Exception $exception) {
            // add warning notification
            
            $this->lastModified = null;
        }
    }
    
    public function getPriority(): string
    {
        return $this->priority;
    }
    
    private function setPriority(float $priority)
    {
        if ($priority > 1) {
            // add warning notification
            
            $priority = 1;
        }
        
        if ($priority < 0) {
            // add warning notification
            
            $priority = 0.1;
        }
        
        $this->priority = $priority;
    }
    
    public function getUrl(): string
    {
        return $this->url;
    }
    
    private function setUrl(string $url): void
    {
        $this->url = str_replace(
            ['&', "'", '"', '>', '<'],
            ['&amp;', '&apos;', '&quot;', '&gt;' , '&lt;'],
            $url
        );
    }
}
