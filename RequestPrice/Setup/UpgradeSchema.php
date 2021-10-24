<?php

namespace Test\RequestPrice\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.6') < 0) {
            $connection = $setup->getConnection();
            $connection->addColumn(
                $setup->getTable('request_price'),
                'created_at',
                [
                    'type' => Table::TYPE_TIMESTAMP,
                    'nullable' => false,
                    'default' => Table::TYPE_TIMESTAMP,
                    'comment' => 'created_at'
                ]
            );
        }
    }
}
