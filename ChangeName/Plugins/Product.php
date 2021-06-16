<?php
namespace Test\ChangeName\Plugins;

class Product
{
    public function aftergetName(\Magento\Catalog\Model\Product $product, $name){
        $price = $product->getData('price');
        if($price < 60){
            $name .= " so cheap";
        }
        else{
            $name .= " so expensive";
        }
        return $name;
    }
}
