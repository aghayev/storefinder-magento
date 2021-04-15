<?php

class Aghayevi_Storefinder_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get CustomerId from Session
     *
     * @return integer
     */
    public function getCustomerId() {

        return Mage::getSingleton('customer/session')->getCustomerId();
    }

    /**
     * Check if enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return Mage::getStoreConfig('storefinder/settings/enable');
    }

    /**
     * Get Yandex API Key
     *
     * @return string
     */
    public function getYandexApiKey()
    {
        return Mage::helper('storefinder/conf')->getYandex('api_key');
    }

    /**
     * Get Yandex Geocode API Url from store config with token formatting
     *
     * @return string
     */
    public function getYandexGeocodeApiUrl($location)
    {
        $urlConfig = Mage::helper('storefinder/conf')->getYandex('geocoding_api_url');

        // Replacing ; with & in url was done due to Magento Adminhtml bug storing & character
        return str_replace(array(';', '[[address]]', '[[yandex_api_key]]'),
            array('&', preg_replace('/ /', '+', $location), $this->getYandexApiKey()), $urlConfig);
    }

    /**
     * Unified logging method to plugin's own log file
     *
     * @param $message
     */
    public function log($message)
    {
        Mage::log($message, null, 'storefinder.log');
    }

    /**
     * Call any API method
     *
     * @param string $method
     * @param string $url
     * @param array|null $params
     * @return object|null
     */
    public function doRequest($method, $url, $params = null)
    {
        $client = $this->__getClient($url);

        try {

            switch ($method) {
                case 'GET':
                default:
                $client->setParameterGet($params);
                $response = $client->request(Zend_Http_Client::GET);
            }

            return $response->getBody();
        }
        catch (Zend_Http_Client_Exception $e) {

            if (Mage::helper('storefinder/conf')->getSettings('debug_mode')) {
                $this->log("Unexpected error occured: " . $e->getMessage());
                $this->log("trace: " . $e->getTraceAsString());
            }
        }
        catch(Exception $e) {
            if (Mage::helper('storefinder/conf')->getSettings('debug_mode')) {
                $this->log("Unexpected error occured: " . $e->getMessage());
                $this->log("trace: " . $e->getTraceAsString());
            }
        }
    }

    /**
     * Get Zend Http Client for cURL like requests
     *
     * @return Zend_Http_Client
     */
    private function __getClient($apiUrl)
    {
        $client = new Zend_Http_Client($apiUrl, array(
            'keepalive' => true,
            'timeout' => 20
        ));

        return $client;
    }
}