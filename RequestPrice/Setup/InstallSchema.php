<?php

namespace Test\RequestPrice\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('request_price')) {
            $tableName = $installer->getTable('request_price');
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    100,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true,
                    ],
                    'Id'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => true,
                        'default' => null,
                    ],
                    'Nick Name'
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => true,
                        'default' => null,
                    ],
                    'Email'
                )
                ->addColumn(
                    'comment',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true,
                        'default' => null,
                    ],
                    'Comment'
                )
                ->addColumn(
                    'sku',
                    Table::TYPE_TEXT,
                    20,
                    [
                        'nullable' => true,
                        'default' => null,
                    ],
                    'Sku'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    10,
                    [
                        'nullable' => false,
                        'default' => 'new',
                    ],
                    'Status'
                )
                ->setComment('RequestPrice');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
