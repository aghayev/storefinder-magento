<?php

/**
 * //localhost:81/index.php/storefinder/product/list
 */
class Aghayevi_Storefinder_ProductController extends Aghayevi_Storefinder_Controller_Abstract
{
    /**
     * List Controller
     */
    public function listAction() {

        $poiId = (int) $this->getRequest()->getParam('id', false);

        // Ajax request
        if ($this->getRequest()->isXmlHttpRequest() 
                && $poiId
        ) {

            try {

                $products = array();

                $collection = Mage::getModel('catalog/product')->getCollection()
                        ->addAttributeToSelect('name')
                        //->addAttributeToSelect('sku')
                        ->addAttributeToSelect('price');
                
                        $collection->getSelect()
                        ->join(array('poi_product' => Mage::getSingleton('core/resource')->getTableName('storefinder/poi_product')),
                                "e.entity_id = poi_product.product_id", array())
                        ->where('poi_id = ' . $poiId);

                if (count($collection) > 0) {

                    foreach ($collection as $product) {
                        //$products[] = array($product->getData());
                        $products[] = array('name' => $product->getName(),'price' => $product->getPrice());
                    }

                    $params = array('success' => true, 'message' => Mage::helper("storefinder")->__("Success"), 'products' => $products);
                } else {
                    Mage::throwException(Mage::helper("storefinder")->__("No data found"));
                }
            } catch (Exception $e) {
                $params = array(
                    "error" => true,
                    "message" => Mage::helper("storefinder")->__($e->getMessage())
                );
            }

            $this->__doAjaxResponse($params);
        }
    }
}