<?php

namespace Rcason\StorePicker\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Rcason\StorePicker\Api\Data\LocationInterfaceFactory;
use Rcason\StorePicker\Api\LocationRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    const STORE_ID = 1;
    
    /**
     * @var CountryInformationAcquirerInterface
     */
    private $countryInformationAcquirer;
    
    /**
     * @var LocationInterfaceFactory
     */
    private $locationFactory;
    
    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;
 
    /**
     * @param CountryInformationAcquirerInterface $countryInformationAcquirer
     * @param LocationInterfaceFactory $locationFactory
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(
        CountryInformationAcquirerInterface $countryInformationAcquirer,
        LocationInterfaceFactory $locationFactory,
        LocationRepositoryInterface $locationRepository
    ) {
        $this->countryInformationAcquirer = $countryInformationAcquirer;
        $this->locationFactory = $locationFactory;
        $this->locationRepository = $locationRepository;
    }
    
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $countries = $this->countryInformationAcquirer->getCountriesInfo();
        foreach ($countries as $country) {
            $location = $this->locationFactory->create()
                ->setCountryId($country->getId())
                ->setStoreId(self::STORE_ID);
            
            $this->locationRepository->save($location);
        }
    }
}
