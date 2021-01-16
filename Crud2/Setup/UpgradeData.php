<?php

namespace Test\Crud2\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $_postFactory;

    public function __construct(\Test\Crud2\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        for ($i = 1; $i < 4; $i++){
            if (version_compare($context->getVersion(), '1.0.7', '<')) {
                $data = [
                    'name'         => "$i Magento 2 Events",
                    'post_content' => "$i This article will talk about Events List in Magento 2. As you know, Magento 2 is using the events driven architecture which will help too much to extend the Magento functionality. We can understand this event as a kind of flag that rises when a specific situation happens. We will use an example module Mageplaza_HelloWorld to exercise this lesson.",
                    'url_key'      => '/magento-2-module-development/magento-2-events.html',
                    'tags'         => 'magento 2, crud',
                    'status'       => 1,
                    'category'       => 'crud'
                ];
                $post = $this->_postFactory->create();
                $post->addData($data)->save();
            }
        }
    }
}
