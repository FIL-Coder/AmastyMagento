<?php

namespace Amasty\FirstModule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    const BLACKLIST_TABLE_NAME = 'amasty_firstmodule_blacklist';

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();

        $table = $setup->getConnection()
                ->newTable($setup->getTable(self::BLACKLIST_TABLE_NAME))
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Product ID in blacklist'
                )
                ->addColumn(
                    'product_sku',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Product SKU'
                )
                ->addColumn(
                    'product_qty',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Product qty'
                )
                ->setComment('Products blacklist');

            $setup->getConnection()->createTable($table);

            $setup->endSetup();
    }
}
