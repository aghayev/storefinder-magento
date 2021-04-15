<?php

class Aghayevi_Storefinder_Block_Adminhtml_Poi_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('storefinderGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('name');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('storefinder/poi')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('poi_id', array(
            'header' => Mage::helper('storefinder')->__('Storefinder ID'),
            'align' => 'right',
            'index' => 'poi_id',
            'width' => '50px',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('storefinder')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        $this->addColumn('address', array(
            'header' => Mage::helper('storefinder')->__('Address'),
            'align' => 'left',
            'index' => 'address',
        ));

        /**
         * Filtering Example
         */
        $this->addColumn('city', array(
            'header' => Mage::helper('storefinder')->__('City'),
            'align' => 'left',
            'index' => 'city',
            'filter_index' => "main_table.city",
            'type' => 'options',
            'options' => Mage::getModel('storefinder/poi')->getOptionArray()
        ));

        $this->addColumn('postcode', array(
            'header' => Mage::helper('storefinder')->__('Postcode'),
            'align' => 'left',
            'index' => 'postcode',
        ));

        $this->addColumn('lat', array(
            'header' => Mage::helper('storefinder')->__('Latitude'),
            'align' => 'left',
            'index' => 'lat',
        ));

        $this->addColumn('lng', array(
            'header' => Mage::helper('storefinder')->__('Longitude'),
            'align' => 'left',
            'index' => 'lng',
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('storefinder')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('storefinder')->__('View'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'id',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }

    /**
     * Retrieve stores grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}