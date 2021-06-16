<?php

namespace Test\Quest\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

use Magento\Framework\App\Config\Storage\WriterInterface;

class CustomData extends AbstractHelper
{
    const QUEST_ENABLED = 'quest/first_sub_quest/enable_module';
    const QUEST_ENABLED_CATEGORY = 'quest/first_sub_quest/list_category';
    const QUEST_END_OF_SALES = 'quest/first_sub_quest/end_of_sales';
    const QUEST_ENABLED_DISCOUNT = 'quest/second_sub_quest/enabled_discount';
    const QUEST_ENABLED_TIME = 'quest/second_sub_quest/enabled_disabled_time';


    public function __construct(
        Context $context,
         WriterInterface $configWriter
    ) {
        $this->_configWriter = $configWriter;
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

    public function getDateEndOfSales(){
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

    public function getEnabledDiscount(){
        return $this->scopeConfig->getValue(
            self::QUEST_ENABLED_DISCOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getEnabledTime(){
        #$this->_configWriter->save('quest/second_sub_quest/enabled_disabled_time', false);
        return $this->scopeConfig->getValue(
            self::QUEST_ENABLED_TIME,
            ScopeInterface::SCOPE_STORE
        );
    }
}
