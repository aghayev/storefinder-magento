<?php

/**
 * Class Aghayevi_Storefinder_Block_Abstract
 */
class Aghayevi_Storefinder_Block_Abstract extends Mage_Core_Block_Template
{

    /**
     * Get Default Lat Lng
     *
     * Geo parameters of default_location
     *
     * @return string
     */
    public function getDefaultLocation()
    {
        return printf("%s,%s",
            Mage::helper('storefinder/conf')->getSettings('default_latitude'),
            Mage::helper('storefinder/conf')->getSettings('default_longitude'));
    }

    /**
     * Get Google Api Key
     *
     * @return string
     */
    public function getGoogleApiKey()
    {
        return Mage::helper('storefinder')->getGoogleApiKey();
    }

    /**
     * Get default zoom for map, if none provided
     *
     * @return integer
     */
    public function getDefaultMapZoom()
    {
        return Mage::helper('storefinder/conf')->getSettings('default_map_zoom');
    }
}