<?php

class Aghayevi_Storefinder_Block_Adminhtml_Poi_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'storefinder';
        $this->_controller = 'adminhtml_poi';
        $this->_mode = 'edit';

        parent::__construct();
        $this->_removeButton('delete');

        $this->_updateButton('save', 'label', Mage::helper('storefinder')->__('Save Changes'));
    }

    public function getHeaderText()
    {
        if (Mage::registry('storefinder_poi_data') && Mage::registry('storefinder_poi_data')->getId()) {
            return Mage::helper('storefinder')->__('Edit POI "%s"', $this->htmlEscape(Mage::registry('storefinder_poi_data')->getTitle()));
        } else {
            return Mage::helper('storefinder')->__('New POI');
        }
    }
}
