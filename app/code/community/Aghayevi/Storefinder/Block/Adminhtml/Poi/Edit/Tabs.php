<?php

class Aghayevi_Storefinder_Block_Adminhtml_Poi_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('storefinder_poi_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('storefinder')->__('Storefinder'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('storefinder')->__('POI Information'),
            'title'     => Mage::helper('storefinder')->__('POI Information'),
            'content'   => $this->getLayout()->createBlock('storefinder/adminhtml_poi_edit_tab_form')->toHtml(),
        ));

        $this->addTab('options_section', array(
            'label'     => Mage::helper('storefinder')->__('Linked Products'),
            'title'     => Mage::helper('storefinder')->__('Linked Products'),
            'content'   => $this->getLayout()->createBlock('storefinder/adminhtml_poi_edit_tab_products')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}