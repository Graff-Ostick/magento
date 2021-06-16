<?php
namespace Test\Crud2\Controller\Index;

use \Test\Crud2\Model\ResourceModel\Post\Collection;

class Category extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_categoryFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Test\Crud2\Model\CategoryFactory $categoryFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_categoryFactory = $categoryFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $category = $this->_categoryFactory->create();
        /** @var Collection $collection */
        $collection = $category->getCollection();
        $collection->addFieldToFilter('category',['in'=>['crud']]);

        foreach($collection as $item){
            echo "<pre>";
            echo('name - '.$item->getName()."<br>");
            echo('url_key - '.$item->getUrlKey()."<br>");
            echo('tags - '.$item->getTags()."<br>");
            echo('category - '.$item->getCategory()."<br>");
            echo('crated_at - '.$item->getCreatedAt()."<br>");
            echo "</pre>";
        }
        exit();
        return $this->_pageFactory->create();
    }
}
