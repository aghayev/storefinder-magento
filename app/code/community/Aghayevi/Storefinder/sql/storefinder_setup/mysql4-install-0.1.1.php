<?php

$installer = $this;
$installer->startSetup();

/**
 * Create Storefinder Table
 *
 * A record called POI - Point Of Interest, because each record has latitude and longitude attributes.
 * The term is used by GPS devices on digital maps
 *
 */
$tableName = $installer->getTable('storefinder_poi');

// Check if the table already exists
if ($installer->getConnection()->isTableExists($tableName) != true) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('poi_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Storefinder Id')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0', // we have default: 0 only because we dont use store_id in this table
            ),
            'Store Id')
        ->addColumn('region_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => false
            ), 'Region/Province')
        ->addColumn('country_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 2,
            array(
                'nullable' => false
            ), 'Country')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => false
            ), 'Name')
        ->addColumn('address', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => false
            ), 'Address')
        ->addColumn('postcode', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50,
            array(
                'nullable' => false
            ), 'PostCode')
        ->addColumn('city', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => false
            ), 'City')
        ->addColumn('lat', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => true
            ), 'Latitude Value')
        ->addColumn('lng', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
            array(
                'nullable' => true
            ), 'Longitude Value')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
            array(
                'nullable' => false,
            ),
            'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
            array(
                'nullable' => false,
            ),
            'Updated At');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();