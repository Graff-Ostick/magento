<?php
namespace Test\Filter\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')->addFinalPrice();
        $collection->getSelect()->where("price_index.final_price < 60");
        $collection->addCategoriesFilter(['eq' => '23']);
        $collection->setPageSize(10);
        return $collection;
    }

}
?>
