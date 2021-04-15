<?php

class Aghayevi_Storefinder_Model_Mysql4_Poi extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi', 'poi_id');
    }
}