<?php

class Aghayevi_Storefinder_Model_Mysql4_Poi_Favourite_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi_favourite');
    }

    /**
     * Get Store location favourites Collection
     *
     * @return Aghayevi_Storefinder_Model_Mysql4_Poi_Favourite_Collection
     */
    public function getFavourites($customerId)
    {

        return $this
            ->addFieldToFilter('customer_id', $customerId)
            ->join(array(
                // $this->getTable throws Can't retrieve entity config: storefinder/storefinder_poi
                'poi' => Mage::getSingleton('core/resource')->getTableName('poi')),
                'poi.poi_id = main_table.poi_id');
    }
}