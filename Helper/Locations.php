<?php

namespace Rcason\StorePicker\Helper;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Store\Model\StoreManagerInterface;

use Rcason\StorePicker\Api\LocationRepositoryInterface;
use Rcason\StorePicker\Model\Cache as StorePickerCache;

class Locations
{
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    
    /**
     * @var LocationRepositoryInterface
     */
    protected $locationRepository;
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @var CountryInformationAcquirerInterface
     */
    protected $countryInformationAcquirer;
    
    /**
     * @var StorePickerCache
     */
    protected $storePickerCache;
    
    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param LocationRepositoryInterface $locationRepository
     * @param StoreManagerInterface $storeManager
     * @param CountryInformationAcquirerInterface $countryInformationAcquirer
     * @param StorePickerCache $storePickerCache
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LocationRepositoryInterface $locationRepository,
        StoreManagerInterface $storeManager,
        CountryInformationAcquirerInterface $countryInformationAcquirer,
        StorePickerCache $storePickerCache
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->locationRepository = $locationRepository;
        $this->storeManager = $storeManager;
        $this->countryInformationAcquirer = $countryInformationAcquirer;
        $this->storePickerCache = $storePickerCache;
    }
    
    /**
     * Return available locations
     */
    public function getLocations()
    {
        \Magento\Framework\Profiler::start('StorePicker_getLocations:' . __METHOD__, [
            'group' => 'StorePicker_getLocations',
            'method' => __METHOD__,
        ]);
        
        // Return from cache
        if ($data = $this->storePickerCache->getLocations()) {
            return $data;
        }
        
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $locations = $this->locationRepository->getList($searchCriteria)
            ->getItems();
        
        // Load informations into data objects
        $data = [];
        foreach ($locations as $location) {
            $data []= new \Magento\Framework\DataObject([
                'country_id' => $location->getCountryId(),
                'country_name' => $this->getCountryName($location->getCountryId()),
                'store_id' => $location->getStoreId(),
                'store_url' => $this->getStoreUrl($location->getStoreId()),
            ]);
        }
        
        // Sort by country name
        usort($data, function($a, $b) {
            $aCountryName = $a->getCountryName();
            $bCountryName = $b->getCountryName();
            
            if ($aCountryName == $bCountryName) {
                return 0;
            }
            return ($aCountryName < $bCountryName) ? -1 : 1;
        });
        
        // Save to cache
        $this->storePickerCache->setLocations($data);
        
        \Magento\Framework\Profiler::stop('StorePicker_getLocations:' . __METHOD__);
        
        return $data;
    }

    /**
     * Return base url by store id
     *
     * @return string
     */
    public function getStoreUrl($storeId)
    {
        return $this->storeManager->getStore($storeId)
            ->getBaseUrl(UrlInterface::URL_TYPE_LINK);
    }

    /**
     * Return country name by code
     *
     * @return string
     */
    public function getCountryName($countryCode)
    {
        return $this->countryInformationAcquirer->getCountryInfo($countryCode)
            ->getFullNameLocale();
    }
}
