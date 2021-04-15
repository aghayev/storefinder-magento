<?php

abstract class Aghayevi_Storefinder_Controller_Abstract extends Mage_Core_Controller_Front_Action
{

    /**
     * Ajax Response Generator
     *
     * @imran - found the following information http://www.php-fig.org/psr/psr-2
     * 4.3. Methods - Method names SHOULD NOT be prefixed with a single underscore to indicate protected or private visibility.
     *
     * @param array $data
     */
    protected function __doAjaxResponse($data)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
    }
}