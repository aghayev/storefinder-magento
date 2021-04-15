<?php

class Aghayevi_Storefinder_Helper_Conf extends Mage_Core_Helper_Abstract
{

    private $prefix = 'storefinder/';

    /**
     * Get <settings> group from etc/system.xml
     *
     * @param $path
     * @return mixed
     */
    public function getSettings($path)
    {
        return $this->__getConfig('settings', $path);
    }

    /**
     * Get <yandex> group from etc/system.xml
     *
     * @param $path
     * @return mixed
     */
    public function getYandex($path)
    {
        return $this->__getConfig('yandex', $path);
    }

    /**
     * Returns Magento StoreLocator Config Info
     *
     * @param $path
     * @return mixed
     */
    private function __getConfig($method, $path)
    {
        return Mage::getStoreConfig($this->prefix. $method .'/' .$path);
    }
}