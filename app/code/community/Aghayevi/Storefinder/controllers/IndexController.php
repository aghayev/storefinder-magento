<?php

/**
 * //localhost:81/index.php/storefinder
 * //localhost:81/index.php/storefinder/index/list
 */
class Aghayevi_Storefinder_IndexController extends Aghayevi_Storefinder_Controller_Abstract
{
    /**
     * Index Controller
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * List Controller
     */
    public function listAction()
    {
        // Ajax request
        if ($this->getRequest()->isXmlHttpRequest()) {

            try {

                $request = $this->getRequest();

                $model = Mage::getModel('storefinder/poi');

                if (null != $request->getParam('lat')
                    && null != $request->getParam('lng')
                ) {

                    $poiData = $model->fetchStoresByLatLng($request->getParam('lat'), $request->getParam('lng'));
                    $params = array('mapCenter' => array('lat' => $request->getParam('lat'), 'lng' => $request->getParam('lng')), 'poiData' => $poiData);

                } else if (null != $request->getParam('place')) {

                    $latLngArray = $model->reverseGeocodingService($this->getRequest()->getParam('place'));

                    $poiData = $model->fetchStoresByLatLng($latLngArray['lat'], $latLngArray['lng']);
                    $params = array('mapCenter' => $latLngArray, 'poiData' => $poiData);

                } else {
                    Mage::throwException(Mage::helper("storefinder")->__("No parameters found"));
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