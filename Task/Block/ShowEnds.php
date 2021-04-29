<?php

namespace Test\Task\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Test\Task\Helper\Data;

class ShowEnds extends Template
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $stockState;
    /**
     * @var Grouped
     */
    protected $grouped;

    /**
     * @var Data
     */
    protected $helper;

    public function __construct(
        Grouped $grouped,
        Template\Context $context,
        Registry $registry,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        Data $helper,
        array $data
    ) {
        $this->registry = $registry;
        $this->grouped = $grouped;
        $this->stockState = $stockState;
        $this->_stockItemRepository = $stockItemRepository;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getOptionsQty()
    {
        $qty = 0;
        $text = '';

        $product = $this->getProduct();
        $childProducts = $product->getTypeInstance()->getUsedProducts($product);
        foreach ($childProducts as $child) {
            $childId = $child->getId();
            $qty += $this->_stockItemRepository->get($childId)->getQty();
        }

        $this->helper->getEndsForProduct() != null ? $text = 'left ' . $qty : $text='';
        return $text;
    }
}
