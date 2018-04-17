<?php

namespace Rcason\StorePicker\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'storepicker_location'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('storepicker_location')
        )->addColumn(
            'country_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            2,
            ['nullable' => false, 'primary' => true],
            'Country ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Store ID'
        )->addForeignKey(
            $installer->getFkName('storepicker_location', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Store Picker Location Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}