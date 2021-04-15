<?php

class Aghayevi_Storefinder_Model_Poi_Favourite extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi_favourite');
    }

    /**
     * Get Store location favourites by CustomerId
     *
     * @param integer $customerId
     */
    public function getFavourites($customerId)
    {
        // @todo add try catch if customerId is null

        return $this->getCollection()->getFavourites($customerId);
    }

    /**
     * Load Favourite by CustomerId and PoiId
     *
     * @param integer $customerId
     * @param integer $poiId
     *
     * @return Aghayevi_Storefinder_Model_Poi_Favourite
     */
    public function loadFavourite($customerId, $poiId)
    {
        return $this->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('poi_id', $poiId)
            ->getFirstItem();
    }
}