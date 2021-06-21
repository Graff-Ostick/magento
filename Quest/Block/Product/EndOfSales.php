<?php

namespace Test\Quest\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Test\Quest\Helper\CustomData;



class EndOfSales extends Template
{
    public $enableTime = true;
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
        TimezoneInterface $timezone,
        array $data
    ) {
        $this->registry = $registry;
        $this->grouped = $grouped;
        $this->stockState = $stockState;
        $this->_stockItemRepository = $stockItemRepository;
        $this->helper = $helper;
        $this->Configurable = $configurableProduct;
        $this->timezone = $timezone;
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

    public function isProductInCategories(){
        $enabledCategoryId = $this->helper->getEnabledCategory();
        $productCategoryId = strval($this->getProduct()->getCategoryIds()[0]);
        return strstr($enabledCategoryId, $productCategoryId);
    }
    public function getEndOfSales(): ?array
    {
        $dateTimeNow = (new \DateTime("now"))->format("y-m-d  H:i:s");
        $endOfSales = $this->helper->getDateEndOfSales();
        $isActual = strtotime($endOfSales) - strtotime($dateTimeNow);
        $isAllowCategory = $this->isProductInCategories();
        $timeLeft = strval(intdiv($isActual,86400)) . ' day(s) '
            . strval(intdiv(bcmod($isActual,86400), 3600)) . ' hour(s) '
            . strval(bcmod(bcmod(bcmod($isActual,86400), 3600), 60)) . ' minute(s) ' ;
        if ( $isAllowCategory and $isActual < 864000 and $isActual > 0){
            return array($endOfSales, $timeLeft);
        }
        else{
            return null;
        }

    }

    public function getPriceWithDiscount(){
        $isAllowCategory = $this->isProductInCategories();
        $product = $this->getProduct();
        $productPrice = $product->getFinalPrice();
        $enabledDiscount = $this->helper->getEnabledDiscount();
        $enableTime=$this->enableTime;
        if($enabledDiscount and $enableTime and $isAllowCategory){
            return $productPrice * 0.9;
        }
        else{
            return null;
        }
    }

    public function getEnabledTime(){
        return  $this->helper->getEnabledTime();
    }

    public function changeProductPrice(){
        if ($this->getPriceWithDiscount()){
            return $this->getProduct()->setFinalPrice($this->getPriceWithDiscount());
        }
        else {
            return null;
        }
    }

}
