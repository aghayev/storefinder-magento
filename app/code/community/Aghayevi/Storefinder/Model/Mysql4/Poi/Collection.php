<?php

class Aghayevi_Storefinder_Model_Mysql4_Poi_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    private $customerId = null;

    protected function _construct() {
        $this->_init('storefinder/poi');

        $this->customerId = Mage::helper("storefinder")->getCustomerId();
    }

    /**
     * Fetch Stores by Latitude and Longitude
     *
     * Utilizes formula to determine the point inside circle using mysql
     *
     * @param string $lat
     * @param string $lng
     * @param int $searchRadius
     *
     * @return Aghayevi_Storefinder_Model_Mysql4_Poi_Collection
     */
    public function fetchStoresByLatLng($lat, $lng, $searchRadius)
    {
        $stores = $this
            ->addFieldToSelect('poi_id')
            ->addFieldToSelect('name')
            ->addFieldToSelect('address')
            ->addFieldToSelect('postcode')
            ->addFieldToSelect('city')
            ->addFieldToSelect('lat')
            ->addFieldToSelect('lng')
            ->addExpressionFieldToSelect('distance_km', 'ROUND(SQRT(POW(lat - {{latitude}}, 2) + POW(lng - {{longitude}} , 2)) * 100,2)',
                array('latitude'=> $lat,'longitude'=> $lng));

        $this->withCustomerIdExpressionField($stores);

        $condition = array("`poi_favourite`.`poi_id` = `main_table`.`poi_id`");
        if (null != $this->customerId) {
            $condition[] = $this->getConnection()->quoteInto('`poi_favourite`.`customer_id` = ?', $this->customerId);
        }

        $stores->getSelect()
            ->joinLeft(array('poi_favourite' => $this->getResource()->getTable('storefinder/poi_favourite')),
                join(" AND ", $condition), array('favourite_id'))
            ->joinLeft(array('poi_product' => $this->getResource()->getTable('storefinder/poi_product')),
                "`poi_product`.`poi_id` = `main_table`.`poi_id`", array('COUNT(poi_product_id) AS in_products'))
            ->group('name')
            ->having('distance_km < '.$searchRadius);

        //Zend_Debug::dump($stores->getSelect()->__toString());exit;

        return $stores;
    }

    /**
     * CustomerId Expression
     */
    private function withCustomerIdExpressionField(&$stores) {

        if (null != $this->customerId) {
            $stores->addExpressionFieldToSelect('not_favourite','IF(`poi_favourite`.`customer_id`={{customer_id}},ISNULL(`poi_favourite`.`favourite_id`),1)',
                    array('customer_id' => Mage::helper("storefinder")->getCustomerId()));
        }
        else {
            $stores->addExpressionFieldToSelect('not_favourite','ISNULL(`poi_favourite`.`favourite_id`)');
        }
    }
}
