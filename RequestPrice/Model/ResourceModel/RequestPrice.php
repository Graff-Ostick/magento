<?php
declare(strict_types=1);

namespace Test\RequestPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Test\RequestPrice\Api\Data\RequestPriceInterface;

/**
 * Request price resource model.
 */
class RequestPrice extends AbstractDb
{
    /** @inheritDoc */
    protected $_idFieldName = RequestPriceInterface::ID;

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(RequestPriceInterface::MAIN_TABLE, RequestPriceInterface::ID);
    }
}
