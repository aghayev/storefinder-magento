<?php

class Aghayevi_Storefinder_Model_Poi extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('storefinder/poi');
    }

    public function getOptionArray() {
        $_options = array();

        $types = array(
            'LONDON'           => 'London',
            'HARROW'           => 'Harrow',
            'CROYDON'          => 'Croydon',
            'UXBRIDGE'         => 'Uxbridge',
            'HOUNSLOW'         => 'Hounslow'
        );

        foreach( $types as $type => $label ) {
                $_options[$type] = $label;
        }

        return $_options;
    }

    /**
     * Lookup latitude and longitude via reservese geocoding service
     *
     * @param string $location
     * @return array
     */
    public function reverseGeocodingService($location)
    {
        $results = null;

        $url = Mage::helper('storefinder')->getYandexGeocodeApiUrl($location);

        $result = Mage::helper('storefinder')->doRequest('GET', $url);

        $xml = new Varien_Simplexml_Element($result);
        $resultsArray = $xml->GeoObjectCollection->featureMember->GeoObject->Point;

        if (isset($resultsArray->pos)) {
            $pieces = explode(" ", $resultsArray->pos);
            $results = ['lat' => $pieces[1], 'lng' => $pieces[0]];
        }

        return $results;
    }

    /**
     * Proxy class for fetching Stores from Resource Collection
     *
     * @param string $lat
     * @param string $lng
     *
     * @return array
     */
    public function fetchStoresByLatLng($lat, $lng)
    {
        $searchRadius = Mage::helper('storefinder/conf')->getSettings('search_radius');

        return $this->getResourceCollection()->fetchStoresByLatLng($lat, $lng, $searchRadius)->getData();
    }

    /**
     * Get Latitude and Longitude by FavouriteId
     *
     * @param integer $favouriteId
     *
     * @return Aghayevi_Storefinder_Model_Poi
     */
    public function getLatLngByFavouriteId($favouriteId)
    {
        return $this->getCollection()
            ->addFieldToFilter('favourite_id', $favouriteId)
            ->join(array(
                'poi_favourite' => Mage::getSingleton('core/resource')->getTableName('poi_favourite')),
                'poi_favourite.poi_id = main_table.poi_id')
            ->getFirstItem();
    }
}