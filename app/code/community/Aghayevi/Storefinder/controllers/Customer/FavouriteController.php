<?php

/**
 * //localhost:81/storefinder/customer_favourite/list
 * //localhost:81/storefinder/customer_favourite/save
 * //localhost:81/storefinder/customer_favourite/delete
 */
class Ahghayevi_Storefinder_Customer_FavouriteController extends Aghayevi_Storefinder_Controller_Customer_Abstract
{
    /**
     * Index Action
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * List Action
     */
    public function listAction()
    {
        $this->indexAction();
    }

    /**
     * Delete Action
     */
    public function deleteAction()
    {

        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }

        $favouriteId = $this->getRequest()->getParam('id', false);

        if ($favouriteId) {

            // March favourite's customerId to Session customerId
            if (Mage::helper("storefinder")->getCustomerId() != $this->_getSession()->getCustomerId()) {
                $this->_getSession()->addError($this->__('The Storefinder Favourite does not belong to this customer.'));
                $this->getResponse()->setRedirect(Mage::getUrl('*/*/index'));
                return false;
            }

            try {

                $poiFavourite = Mage::getModel('storefinder/poi_favourite')->load($favouriteId);

                $poiFavourite->delete();

                $this->_getSession()->addSuccess($this->__('The Storefinder Favourite has been deleted.'));
            } catch (Exception $e) {
                $this->_getSession()->addException($e, $this->__('An error occurred while deleting the Storefinder Favourite.'));
            }
        }
        $this->getResponse()->setRedirect(Mage::getUrl('*/*/list'));
    }

    /**
     * Save Controller
     */
    public function saveAction()
    {

        $poiId = (int) $this->getRequest()->getParam('id',false);

        // Ajax request
        if ($this->getRequest()->isXmlHttpRequest()
            && $poiId
        ) {

            try {
                $customerId = Mage::helper("storefinder")->getCustomerId();
                $favourite = Mage::getModel('storefinder/poi_favourite')->loadFavourite($customerId, $poiId);

                if (!$favourite->getId()) {

                    $newPOIFavourite = Mage::getModel('storefinder/poi_favourite');
                    $newPOIFavourite->setData('poi_id', $poiId);
                    $newPOIFavourite->setData('customer_id', $customerId);
                    $newPOIFavourite->setData('created_at', Varien_Date::now());

                    $newPOIFavourite->save();

                    $params = array('success' => true, 'message' => Mage::helper("storefinder")->__("Success"));
                } else {
                    Mage::throwException("Storefinder Favourite already added");
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

    /**
     * Get Favourite
     */
    public function getAction()
    {

        $favouriteId = (int) $this->getRequest()->getParam('id',false);

        // Ajax request
        if ($this->getRequest()->isXmlHttpRequest()
            && $favouriteId
        ) {

            try {

                $latLng = Mage::getModel('storefinder/poi')->getLatLngByFavouriteId($favouriteId);

                if ($latLng->getFavouriteId() == $favouriteId) {
                    $params = array(
                        'success' => true,
                        'message' => Mage::helper("storefinder")->__("Success"),
                        'name' => $latLng->getName(),
                        'lat' => (float)$latLng->getLat(),
                        'lng' => (float)$latLng->getLng()
                    );
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