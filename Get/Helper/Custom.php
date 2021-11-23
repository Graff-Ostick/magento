<?php

namespace Test\Get\Helper;

/** Helper for Custom product templates */

class Custom extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var array */
    private $_availableSku = [
        'MJ01',
        'Mj01',
        'MJ02'
    ];

    /** Validete template visualization for given product sku
     *
     * @param string $sku
     *@retrun bool
     */

    public function validateProductBySku($sku)
    {
        if (in_array($sku, $this->getValidSkuArray())){
            return true;
        } else {
            return false;
        }
    }

    protected function getValidSkuArray(){
        return $this->_availableSku;
    }

}
