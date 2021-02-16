<?php
namespace Test\Get\Block;

use Magento\CatalogRule\Model\RuleFactory;
use Magento\Store\Model\StoreManagerInterface;

class HelloWorld extends \Magento\Framework\View\Element\Template
{
    protected $_catalogProductTypeConfigurable;
    protected $_productRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var RuleFactory
     */
    protected $_ruleFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $catalogProductTypeConfigurable,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        RuleFactory $ruleFactory,
        array $data = []
    ) {
        $this->_catalogProductTypeConfigurable = $catalogProductTypeConfigurable;
        $this->_productRepository = $productRepository;
        $this->_storeManager = $storeManager;
        $this->_ruleFactory = $ruleFactory;
        parent::__construct($context, $data);
    }

    /**
     * return product
     * @param $id
     */
    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getCatalogPriceRuleProductIds()
    {
        $store = $this->_storeManager->getStore()->getId();

        $catalogRule = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\CatalogRule\Model\RuleFactory'
        );

        $websiteId = $store;

        $resultProductIds = [];
        $catalogRuleCollection = $catalogRule->create()->getCollection();
        $catalogRuleCollection->addIsActiveFilter(1);//filter for active rules only
        foreach ($catalogRuleCollection as $catalogRule) {
            $productIdsAccToRule = $catalogRule->getMatchingProductIds();
            foreach ($productIdsAccToRule as $productId => $ruleProductArray) {
                if (!empty($ruleProductArray[$websiteId])) {
                    $resultProductIds[$productId] = $catalogRule->getName();//name of rule
                }
            }
        }
        return $resultProductIds;
    }

}
