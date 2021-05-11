<?php

namespace Test\Quest\Block\product;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Test\Quest\Helper\CustomData;

class EndOfSales extends Template
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
     * @var StockStateInterface
     */
    protected $stockState;
    /**
     * @var Grouped
     */
    protected $grouped;

    /**
     * @var CustomData
     */
    protected $helper;
    /**
     * @var Configurable
     */
    protected $Configurable;

    public function __construct(
        Grouped $grouped,
        Template\Context $context,
        Registry $registry,
        StockStateInterface $stockState,
        StockItemRepository $stockItemRepository,
        CustomData $helper,
        Configurable $configurableProduct,
        array $data
    ) {
        $this->registry = $registry;
        $this->grouped = $grouped;
        $this->stockState = $stockState;
        $this->_stockItemRepository = $stockItemRepository;
        $this->helper = $helper;
        $this->Configurable = $configurableProduct;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getEndOfSales(){
        return $this->helper->getEndOfSales();
    }
}
