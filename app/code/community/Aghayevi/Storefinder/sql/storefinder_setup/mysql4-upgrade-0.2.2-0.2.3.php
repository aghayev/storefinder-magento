<?php

$installer = $this;
$installer->startSetup();

/**
 * Create Storefinder Favourite Table
 */
$tableName = $installer->getTable('storefinder_poi_product');

// Check if the table already exists
if ($installer->getConnection()->isTableExists($tableName) != true) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('poi_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'POI Product Id')
        ->addColumn('poi_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'POI Id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'Product Id');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();