<?php

namespace Test\Task\Block;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Test\Task\Helper\CustomData;

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

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getOptionsQty()
    {
        $qty = 0;

        $product = $this->getProduct();
        if ($product->getTypeId() == 'configurable' ) {
            $childProducts = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($childProducts as $child) {
                $childId = $child->getId();
                $qty += $this->_stockItemRepository->get($childId)->getQty();
            }
        }
        else {
            $qty = $this->_stockItemRepository->get($product->getId())->getQty();
        }

        $this->helper->getEndsForProduct() >= $qty ? $text = 'left ' . $qty : $text='';
        return $text;
    }

    /**
     * @throws LocalizedException
     */
    public function getTransportationPrice()
    {
        $product = $this->getProduct();
        $productWeight = $product->getWeight();
        $freePayWeight = $this->helper->getFreePayWeight();
        $payWeight = $this->helper->getPayWeight();
        $transportationCost = $this->helper->getTransportationCost();

        if($this->helper->getEnableTransportationCost() && $productWeight > $freePayWeight){
            return ceil(($productWeight - $freePayWeight) / $payWeight) * $transportationCost;
        }
        else {
            return null;
        }
    }
}
