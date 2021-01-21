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
    public function getProductData($id){
        $parentByChild = $this->_catalogProductTypeConfigurable->getParentIdsByChild($id);
        if(isset($parentByChild[0])){
            $id = $parentByChild[0];
        }
        return $id;
    }
    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
?>
