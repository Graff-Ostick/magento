<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\RequestPrice\Model\ResourceModel\RequestPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'Test\RequestPrice\Model\RequestPrice',
            'Test\RequestPrice\Model\ResourceModel\RequestPrice'
        );
    }
}
