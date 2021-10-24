<?php

namespace Test\RequestPrice\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * RequestPrice RequestPrice mysql resource.
 */
class RequestPrice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * @var DateTime
     */
    protected $_date;

    /**
     * Construct.
     *
     * @param Context $context
     * @param DateTime       $date
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        Context $context,
        DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    /**
     * Initialize resource model.
     */
    public function _construct()
    {
        $this->_init('request_price', 'id');
    }
}
