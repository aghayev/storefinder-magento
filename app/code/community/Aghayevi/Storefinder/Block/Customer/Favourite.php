<?php

/**
 * Class Aghayevi_Storefinder_Block_Customer_Favourite
 *
 * Customer dashboard show POI Favourite information
 */
class Aghayevi_Storefinder_Block_Customer_Favourite extends Aghayevi_Storefinder_Block_Abstract
{

    /**
     * Get Back Url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('customer/account/', array('_secure' => true));
    }

    /**
     * Get Delete Url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('storefinder/customer_favourite/delete',
            array(Mage_Core_Model_Url::FORM_KEY => Mage::getSingleton('core/session')->getFormKey()));
    }

    /**
     * Get Customer Favourites
     *
     * @return VisionDirect_StoreLocator_Model_Mysql4_Poi_Favourite_Collection
     */
    public function getCustomerFavourites()
    {
        return Mage::getModel('storefinder/poi_favourite')->getFavourites($this->_getCustomerId());
    }

    /**
     * Get Customer Id
     *
     * @return string
     */
    private function _getCustomerId()
    {

        return Mage::helper("storefinder")->getCustomerId();
    }
}