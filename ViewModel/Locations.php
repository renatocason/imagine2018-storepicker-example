<?php

namespace Rcason\StorePicker\ViewModel;

use Rcason\StorePicker\Helper\Locations as LocationsHelper;
use Rcason\StorePicker\Model\Location as LocationModel;

class Locations implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var LocationsHelper
     */
    protected $locationsHelper;

    /**
     * @param LocationsHelper $locationsHelper
     */
    public function __construct(LocationsHelper $locationsHelper)
    {
        $this->locationsHelper = $locationsHelper;
    }
    
    /**
     * Return available locations
     */
    public function getLocations()
    {
        return $this->locationsHelper->getLocations();
    }
}
