<?php

namespace Test\Task\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class CustomData extends AbstractHelper
{
    const TASK_ENABLED_UAH    = 'task/general/enable_uah';
    const TASK_CURRENCY_UAH   = 'task/general/currency_uah';
    const TASK_ENABLED_RUB    = 'task/general/enable_rub';
    const TASK_CURRENCY_RUB   = 'task/general/currency_rub';
    const TASK_ENABLED_EURO    = 'task/general/enable_euro';
    const TASK_CURRENCY_EURO   = 'task/general/currency_euro';

    const SHOW_ENDS_ENABLE = 'task/ends/enable_second_task';
    const SHOW_ENDS_VALUE = 'task/ends/amount_product';

    const TRANSPORTATION_ENABLE = 'task/price_transportation/enable_price_transportation';
    const FREE_WEIGHT = 'task/price_transportation/free_weight';
    const PAY_WEIGHT = 'task/price_transportation/pay_weight';
    const TRANSPORTATION_COST = 'task/price_transportation/transportation_cost';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    public function getEnabledCurrency($enableCurrency)
    {
        $enableUAH = $this->scopeConfig->getValue(
            self::TASK_ENABLED_UAH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $enableRUB = $this->scopeConfig->getValue(
            self::TASK_ENABLED_RUB,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $enableEURO = $this->scopeConfig->getValue(
            self::TASK_ENABLED_EURO,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        switch ($enableCurrency) {
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
        if ($this->getEnabledCurrency('uah')) {
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_UAH,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        } else {
            return null;
        }
    }
    public function getLabelCurrencyRUB()
    {
        if ($this->getEnabledCurrency('rub')) {
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_RUB,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        } else {
            return null;
        }
    }
    public function getLabelCurrencyEURO()
    {
        if ($this->getEnabledCurrency('euro')) {
            return $this->scopeConfig->getValue(
                self::TASK_CURRENCY_EURO,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        } else {
            return null;
        }
    }

    public function getEndsForProduct()
    {
        $enable = $this->scopeConfig->getValue(
            self::SHOW_ENDS_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($enable) {
            $ends = $this->scopeConfig->getValue(
                self::SHOW_ENDS_VALUE,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        } else {
            $ends = null;
        }

        return $ends;
    }

    public function getEnableTransportationCost(){
        return $this->scopeConfig->getValue(
            self::TRANSPORTATION_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

    }

    public function getFreePayWeight(){

         return $this->scopeConfig->getValue(
            self::FREE_WEIGHT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

    }

    public function getPayWeight(){

        return $this->scopeConfig->getValue(
            self::PAY_WEIGHT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getTransportationCost(){

        return $this->scopeConfig->getValue(
            self::TRANSPORTATION_COST,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }


}
