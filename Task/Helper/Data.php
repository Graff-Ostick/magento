<?php

namespace Test\Task\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const TASK_ENABLED_UAH    = 'task/general/enable_uah';
    const TASK_CURRENCY_UAH   = 'task/general/currency_uah';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
    public function getEnabledUAH()
    {
        return $this->scopeConfig->getValue(
            self::TASK_ENABLED_UAH ,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getLabelCurrencyUAH()
    {
        return$this->scopeConfig->getValue(
            self::TASK_CURRENCY_UAH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
