<?php

class Aghayevi_Storefinder_Block_Adminhtml_Poi_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $vendor = Mage::registry('storefinder_poi_data');

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('poi_form', array(
            'legend' =>Mage::helper('storefinder')->__('POI Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('storefinder')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name'
        ));

        $fieldset->addField('address', 'text', array(
            'label'     => Mage::helper('storefinder')->__('Address'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'address'
        ));

        $fieldset->addField('postcode', 'text', array(
            'label'     => Mage::helper('storefinder')->__('Postcode'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'postcode'
        ));

        $fieldset->addField('city', 'text', array(
            'label'     => Mage::helper('storefinder')->__('City'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'city'
        ));

        $fieldset->addField('lat', 'text', array(
            'label'     => Mage::helper('storefinder')->__('Latitude'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'lat'
        ));

        $fieldset->addField('lng', 'text', array(
            'label'     => Mage::helper('storefinder')->__('Longitude'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'lng'
        ));

        $this->setForm($form);
        $form->setValues($vendor->getData());

        return parent::_prepareForm();
    }

    public function filter($value)
    {
        return number_format($value, 2);
    }
}