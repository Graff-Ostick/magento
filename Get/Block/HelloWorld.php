<?php
namespace Test\Get\Block;
class HelloWorld extends \Magento\Framework\View\Element\Template
{
    protected $_catalogProductTypeConfigurable;
    protected $_productRepository;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $catalogProductTypeConfigurable,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        $this->_catalogProductTypeConfigurable = $catalogProductTypeConfigurable;
        $this->_productRepository = $productRepository;
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
        $storeManager = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Store\Model\StoreManagerInterface'
        );
        $catalogRule = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\CatalogRule\Model\RuleFactory'
        );

        $websiteId = $storeManager->getStore()->getWebsiteId();//current Website Id

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

    /**
     * return list of name by all rules
     * @param $arrData
     */
    public function getListNameProductFromRule($arrData){
        $arrNames = [];
        foreach ($arrData as $key => $value){
            array_push($arrNames, $this->getProductById($key)->getName());
        }
        return $arrNames;
    }

}
?>
