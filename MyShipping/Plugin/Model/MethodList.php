<?php

namespace Test\MyShipping\Plugin\Model;

class MethodList
{

     public function afterGetAvailableMethods(
        \Magento\Payment\Model\MethodList $subject,
        $availableMethods,
        \Magento\Quote\Api\Data\CartInterface $quote = null
    )
    {
        $shippingMethod = $this->getShippingMethodFromQuote($quote);
        foreach ($availableMethods as $key => $method) {

            if (($shippingMethod != 'simpleshipping_simpleshipping') && ($method->getCode() == 'custompayment')) {
                unset($availableMethods[$key]);
            }
        }

        return $availableMethods;
    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return string
     */
    private function getShippingMethodFromQuote($quote)
    {
        if ($quote) {
            return $quote->getShippingAddress()->getShippingMethod();
        }
        return '';
    }
}
