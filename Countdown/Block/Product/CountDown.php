<?php
declare(strict_types=1);

namespace Test\Countdown\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Test\Quest\Helper\CustomData;

class CountDown extends Template
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    public function __construct(
        TimezoneInterface $timezone,
        Template\Context $context,
        Registry $registry,
        array $data
    )
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
        $this->timezone = $timezone;
    }

    /**
     * @return Product
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

    public function timeLeft(){
        $endTime = strtotime($this->getProduct()->getSpecialToDate());
        $timeNow = strtotime(date('Y-m-d h:m:s'));
        $left = $endTime-$timeNow;
        return gmdate('d h:m:s', $left);
    }

    public function timeEnd(){
        $specialPrice =  $this->getProduct()->getSpecialToDate();
        $timeNow = strtotime(date('Y-m-d h:m:s'));
        if (strtotime($specialPrice)>$timeNow){
            return $specialPrice;
        }
        else{
            return null;
        }
    }
}
