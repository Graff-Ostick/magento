<?php

namespace Test\Task\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const TASK_ENABLED_UAH    = 'task/general/enable_uah';
    const TASK_CURRENCY_UAH   = 'task/general/currency_uah';
    const TASK_ENABLED_RUB    = 'task/general/enable_rub';
    const TASK_CURRENCY_RUB   = 'task/general/currency_rub';
    const TASK_ENABLED_EURO    = 'task/general/enable_euro';
    const TASK_CURRENCY_EURO   = 'task/general/currency_euro';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    public function getEnabledCurrency($enableCurrency)
    {
        $enableUAH = $this->scopeConfig->getValue(
            self::TASK_ENABLED_UAH ,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $enableRUB = $this->scopeConfig->getValue(
            self::TASK_ENABLED_RUB ,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $enableEURO = $this->scopeConfig->getValue(
            self::TASK_ENABLED_EURO ,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        switch ($enableCurrency){
            case 'uah':
                return $enableUAH;
            case 'rub':
                return $enableRUB;
            case 'euro':
                return $enableEURO;
        }
    }
    public function getLabelCurrencyUAH()
    {

        if ($this->getEnabledCurrency('uah')){
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_UAH,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        else{
            return NULL;
        }

    }
    public function getLabelCurrencyRUB()
    {
        if ($this->getEnabledCurrency('rub')) {
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_RUB,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        else{
            return NULL;
        }
    }
    public function getLabelCurrencyEURO()
    {
        if ($this->getEnabledCurrency('euro')) {
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_EURO,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        else {
            return NULL;
        }
    }
}
