<?php

namespace Rcason\StorePicker\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class Uninstall implements UninstallInterface
{
    /**
     * @inheritdoc
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        $tables = [
            $setup->getTable('storepicker_location'),
        ];
        
        foreach($tables as $table) {
            if(!$setup->tableExists($table)) {
                continue;
            }
            
            $setup->getConnection()->dropTable($table);
        }
 
        $setup->endSetup();
    }
}
