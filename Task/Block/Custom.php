<?php

namespace Test\Task\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Test\Task\Helper\CustomData;

class Custom extends ListProduct
{
    protected $_productRepository;

    protected $helper;
    /**
     * @var StockItemRepository
     */
    protected $_stockItemRepository;
    /**
     * @var ProductRepositoryInterface
     */

    /**
     * Custom constructor.
     * @param CustomData $helper
     * @param Data $urlHelper
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ProductRepositoryInterface $productRepository
     * @param StockItemRepository $stockItemRepository
     * @param array $data
     */
    public function __construct(
        CustomData $helper,
        Data $urlHelper,
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        StockItemRepository $stockItemRepository,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_productRepository = $productRepository;
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

    public function getQtyProduct($product): string
    {
        $qty = 0;

        if ($product->getTypeId() == 'configurable') {
            $childProducts = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($childProducts as $child) {
                $childId = $child->getId();
                $qty += $this->_stockItemRepository->get($childId)->getQty();
            }
        } else {
            $qty = $this->_stockItemRepository->get($product->getId())->getQty();
        }

        $this->helper->getEndsForProduct() >= $qty ? $text = 'Ends' : $text='';
        return $text;
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getWeightProduct($product)
    {
        if ($product->getTypeId() == 'configurable') {
            $childProducts = $product->getTypeInstance()->getUsedProducts($product);
            $maxWeight = 0;
            foreach ($childProducts as $child) {
                ($child->getData('weight') >= $maxWeight) ? $maxWeight = $child->getData('weight') : NULL;
            }
        } else {
            $idProduct = $product->getId();
            $maxWeight = $this->_productRepository->getById($idProduct)->getWeight();
        }
        return $maxWeight;
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function checkTransportationCost($product): ?string
    {
        $weight = $this->getWeightProduct($product);
        $freePayWeight = $this->helper->getFreePayWeight();
        if ($this->helper->getEnableTransportationCost() && $weight>$freePayWeight){
            return 'Air freight surcharge';
        }
        else {
            return null;
        }
    }

    public function checkPayCost(){

    }
}
