<?php

$installer = $this;
$installer->startSetup();

/**
 * Create Storefinder Favourite Table
 */
$tableName = $installer->getTable('storefinder_poi_favourite');

// Check if the table already exists
if ($installer->getConnection()->isTableExists($tableName) != true) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('favourite_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Favourite Id')
        ->addColumn('poi_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'POI Id')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'Customer Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
            array(
                'nullable' => false,
            ),
            'Created At');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();