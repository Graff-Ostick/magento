<?php

namespace Test\ChangeName\Model;

class Product extends \Magento\Catalog\Model\Product
{

    public function getName()
    {
        $name = parent::getName();

        $price = $this->getData('price');

        if ($price < 60) {
            $name .= " so cheap";
        } else {
            $name .= " so expensive";
        }
        return $name;

    }

}
