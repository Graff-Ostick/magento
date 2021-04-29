<?php

namespace Test\Task\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Data\Helper\PostHelper;
use Test\Task\Helper\Data;

class Custom extends \Magento\Catalog\Block\Product\ListProduct
{
    protected $_productRepository;

    protected $helper;

    /**
     * Custom constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     * @param array $data
     */
    public function __construct(
        Data $helper,
        \Magento\Catalog\Block\Product\Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getCurrencyUAH()
    {
        return $this->helper->getLabelCurrencyUAH();
    }

    public function getCurrencyRUB()
    {
        return $this->helper->getLabelCurrencyRUB();
    }

    public function getCurrencyEURO()
    {
        return $this->helper->getLabelCurrencyEURO();
    }

    public function getEndsProductValue()
    {
        return $this->helper->getEndsForProduct();
    }
}
