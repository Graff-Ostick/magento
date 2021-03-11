<?php
namespace Test\Filter\Block;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\Price;
use Magento\Catalog\Api\Data\ProductInterface;

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
        $collection->addAttributeToSelect(['SKU', 'Name', 'Price']);
        $collection->addCategoriesFilter(['in' => '23']);
        $collection->addAttributeToFilter(ProductInterface::PRICE, ['lt' => 60]);
        $collection->setPageSize(10);
        return $collection;
    }

}
?>
