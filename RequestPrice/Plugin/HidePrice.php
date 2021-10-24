<?php

namespace Test\RequestPrice\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;

class HidePrice
{
    /**
     * @param FinalPriceBox $subject
     * @param $result
     * @return mixed|string
     */
    function afterToHtml(FinalPriceBox $subject, $result)
    {
        if ($subject) {
            return '';
        } else {
            return $result;
        }
    }
}
