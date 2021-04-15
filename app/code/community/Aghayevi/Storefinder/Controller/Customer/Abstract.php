<?php

abstract class Aghayevi_Storefinder_Controller_Customer_Abstract extends Aghayevi_Storefinder_Controller_Abstract
{

    /**
     * Pre Dispatach Check
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }

    /**
     * Retrieve Customer Session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}