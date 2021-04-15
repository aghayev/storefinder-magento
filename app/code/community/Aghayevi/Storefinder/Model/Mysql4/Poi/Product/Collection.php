<?php

class Aghayevi_Storefinder_Model_Mysql4_Poi_Product_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi_product');
    }

    /**
     * Get Store location product Ids
     *
     * @return Aghayevi_Storefinder_Model_Mysql4_Poi_Product_Collection
     */
    public function getProductIds($poiId)
    {
        return $this->addFieldToFilter('poi_id', $poiId);
    }
}