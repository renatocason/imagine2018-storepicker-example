<?php

// @codingStandardsIgnoreFile

namespace Rcason\StorePicker\Model;

use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;

class Cache extends TagScope
{
    const TYPE_IDENTIFIER  = 'storepicker';
    const CACHE_TAG        = 'STOREPICKER';
    const CACHE_TTL        = 84600;

    /**
     * @var StateInterface
     */
    protected $cacheState;

    /**
     * @param FrontendPool $cacheFrontendPool
     * @param StateInterface $cacheState
     */
    public function __construct(
        FrontendPool $cacheFrontendPool,
        StateInterface $cacheState
    ) {
        $this->cacheState = $cacheState;
        
        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }

    /**
     * Set locations cache entry
     */
    public function setLocations($data)
    {
        if (!$this->cacheState->isEnabled(self::TYPE_IDENTIFIER)) {
            return false;
        }
        
        return $this->save(
            json_encode($data),
            self::TYPE_IDENTIFIER . '_locations',
            [Location::CACHE_KEY],
            self::CACHE_TTL
        );
    }
    
    /**
     * Return locations from cache
     */
    public function getLocations()
    {
        if (!$this->cacheState->isEnabled(self::TYPE_IDENTIFIER)) {
            return false;
        }
        
        $value = $this->load(
            self::TYPE_IDENTIFIER . '_locations'
        );
        
        return $value ? json_decode($value) : false;
    }
}
