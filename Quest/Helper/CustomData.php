<?php

namespace Test\Quest\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class CustomData extends AbstractHelper
{
    const QUEST_ENABLED = 'quest/first_quest/enable_module';
    const QUEST_ENABLED_CATEGORY = 'quest/first_quest/list_category';
    const QUEST_END_OF_SALES = 'quest/first_quest/end_of_sales';

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getEnabledModule(){
        return $this->scopeConfig->getValue(
            self::QUEST_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }


    /**
     * @return mixed|string
     */
    public function getEnabledCategory(){
        if ($this->getEnabledModule()){
            return $this->scopeConfig->getValue(
                self::QUEST_ENABLED_CATEGORY,
                ScopeInterface::SCOPE_STORE
            );
        }
        else{
            return '';
        }
    }

    public function getEndOfSales(){
        if ($this->getEnabledModule()){
            return $this->scopeConfig->getValue(
                self::QUEST_END_OF_SALES,
                ScopeInterface::SCOPE_STORE
            );
        }
        else{
            return '';
        }
    }
}
