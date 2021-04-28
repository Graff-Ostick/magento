<?php

namespace Test\Task\Block;

use \Test\Task\Helper\Data;
use \Magento\Backend\Block\Template\Context;
use \Magento\Catalog\Model\ProductRepository;


class Custom extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;

    public function __construct(
        Context $context,
        ProductRepository $productRepository,
        Data $helper,
        array $data = []
    )
    {
        $this->_productRepository = $productRepository;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getCurrencyUAH()
    {

        return $this->helper->getLabelCurrencyUAH();
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
