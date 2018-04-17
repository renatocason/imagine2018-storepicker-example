<?php

// @codingStandardsIgnoreFile

namespace Rcason\StorePicker\Model;

use Rcason\StorePicker\Api\Data\LocationInterface;
use Rcason\StorePicker\Model\ResourceModel\Location as ResourceModel;

/**
 * Location model
 */
class Location extends \Magento\Framework\Model\AbstractModel implements LocationInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
    
    /**
     * @inheritdoc
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::KEY_COUNTRY_ID, $countryId);
    }

    /**
     * @inheritdoc
     */
    public function getCountryId()
    {
        return $this->_getData(self::KEY_COUNTRY_ID);
    }
    
    /**
     * @inheritdoc
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::KEY_STORE_ID, $storeId);
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->_getData(self::KEY_STORE_ID);
    }
}
