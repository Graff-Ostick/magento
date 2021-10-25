<?php
declare(strict_types=1);

namespace Test\RequestPrice\Model\ResourceModel\RequestPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Test\RequestPrice\Model\RequestPrice as RequestPriceModel;
use Test\RequestPrice\Model\ResourceModel\RequestPrice as RequestPriceResource;

/**
 * Request price collection.
 */
class Collection extends AbstractCollection
{
    /** @inheritDoc */
    protected $_idFieldName = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(RequestPriceModel::class, RequestPriceResource::class);
    }
}
