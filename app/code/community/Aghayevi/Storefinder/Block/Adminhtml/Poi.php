<?php

class Aghayevi_Storefinder_Block_Adminhtml_Poi extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'storefinder';
        $this->_controller = 'adminhtml_poi';
        $this->_headerText = Mage::helper('storefinder')->__('Storefinder POI Editor');
        $this->_addButtonLabel = $this->__('Add New POI');
        parent::__construct();
    }
}