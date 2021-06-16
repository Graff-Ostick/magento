<?php
declare(strict_types=1);

namespace Test\GetPrice\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\CatalogRule\Model\ResourceModel\Rule;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Customer\Model\Group;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Store\Model\StoreManagerInterface;
use Test\GetPrice\Helper\CustomData;

class ShowPrice extends Template
{
    /** @var Registry */
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
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * @var Session
     */
    private $session;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Rule
     */
    private $rule;


    public function __construct(
        Rule $rule,
        Template\Context $context,
        Grouped $grouped,
        Registry $registry,
        StockStateInterface $stockState,
        StockItemRepository $stockItemRepository,
        CustomData $helper,
        Configurable $configurableProduct,
        TimezoneInterface $timezone,
        Session $session,
        StoreManagerInterface $storeManager,
        array $data
    ) {
        $this->_stockItemRepository = $stockItemRepository;
        $this->helper = $helper;
        $this->Configurable = $configurableProduct;
        parent::__construct($context, $data);
        $this->grouped = $grouped;
        $this->registry = $registry;
        $this->stockState = $stockState;
        $this->rule = $rule;
        $this->timezone = $timezone;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    /**
     * @return Product
     * @throws LocalizedException
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
     * @return float
     * @throws LocalizedException
     */
    public function showBasePrice(): float
    {
        if ($this->helper->showBasePrice()) {
            return (float)$this->getProduct()->getPrice();
        }
    }

    /**
     * @return float
     * @throws LocalizedException
     */
    public function showFinalPrice(): float
    {
        if ($this->helper->showFinalPrice()) {
            return (float)$this->getProduct()->getFinalPrice();
        }
    }

    /**
     * @return float
     * @throws LocalizedException
     */
    public function showSpecialPrice(): float
    {
        if ($this->helper->showSpecialPrice()) {
            return (float)$this->getProduct()->getSpecialPrice();
        }
    }

    /**
     * @return array|float|null
     * @throws LocalizedException
     */
    public function showTierPrice()
    {
        $tierPrice = $this->getProduct()->getTierPrice();

        return $this->helper->showTierPrice() && $tierPrice != null ? $tierPrice : null;

    }

    /**
     * @return mixed
     * @throws LocalizedException
     */
    public function showCatalogPrice(): bool
    {
        if ($this->helper->showCatalogPrice()) {
            $productId = $this->getProduct()->getId();
            $date = $this->timezone->date()->getTimestamp();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $customerGroupId = $this->getCustomerGroupId();

            return (bool)$this->rule->getRulesFromProduct($date, $websiteId, $customerGroupId, $productId);
        }
    }

    /**
     * @return int
     */
    private function getCustomerGroupId() : int
    {
        if ($this->session->isLoggedIn()) {
            return (int)$this->session->getCustomer()->getGroupId();
        }

        return Group::NOT_LOGGED_IN_ID;
    }
}

