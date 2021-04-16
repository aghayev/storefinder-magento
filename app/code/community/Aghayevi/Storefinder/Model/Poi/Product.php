<?php

class Aghayevi_Storefinder_Model_Poi_Product extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi_product');
    }

    /**
     * Load Product by ProductId and PoiId
     *
     * @param integer $productId
     * @param integer $poiId
     *
     * @return Aghayevi_Storefinder_Model_Poi_Product
     */
    public function loadProduct($productId, $poiId)
    {
        return $this->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->addFieldToFilter('poi_id', $poiId)
            ->getFirstItem();
    }

    /**
     * Get EAV Products joined with POI Product Data
     * 
     * @param integer $poiId
     * 
     * @return Aghayevi_Storefinder_Model_Mysql4_Poi_Product_Collection
     */
    public function getProducts($poiId)
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price');

            $collection->getSelect()
                    ->join(array('mep' => "storefinder_poi_product"), "e.entity_id = mep.product_id", array('mep.*'))
                    ->having('mep.poi_id = '.$poiId);
        
        
    }
}
