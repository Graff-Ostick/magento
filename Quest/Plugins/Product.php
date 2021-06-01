<?php
namespace Test\Quest\Plugins;

use Magento\Catalog\Model\CategoryRepository;
use Test\Quest\Helper\CustomData;


class Product
{

    protected $customHelper;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        CustomData $customHelper,
        CategoryRepository $categoryRepository
    ) {
        $this->customHelper=$customHelper;
        $this->categoryRepository = $categoryRepository;
    }

    public function afterGetName(\Magento\Catalog\Model\Product $product, $name){
        $productCategoryIds = $product->getCategoryIds();
        $productCategoryName =  $this->categoryRepository->get(end($productCategoryIds))->getName();
        $allowsCategory = explode(",", $this->customHelper->getEnabledCategory());
        if (array_intersect($productCategoryIds, $allowsCategory)){
            $name.= ' ' . $productCategoryName . "_" . $product->getId() . "_" . $product->getSku() . "_" .$product->getTypeId();
        }
        return $name;
    }


    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $price)
    {
        $allowsCategory = explode(",", $this->customHelper->getEnabledCategory());
        $productCategoryIds = $subject->getCategoryIds();
        $discountTime = $this->customHelper->getEnabledTime();
        if (array_intersect($productCategoryIds, $allowsCategory) && $discountTime){
            $price *=0.9;
        }
        return $price ;
    }

}
