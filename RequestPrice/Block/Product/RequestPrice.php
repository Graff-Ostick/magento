<?php
declare(strict_types=1);

namespace Test\RequestPrice\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Request price block.
 */
class RequestPrice extends Template
{
    /** @var Registry */
    protected $registry;
    
    /** @var DateTime */
    protected $date;

    /** @var Product */
    protected $product;

    /**
     * @param DateTime         $date
     * @param Template\Context $context
     * @param Registry         $registry
     * @param array            $data
     */
    public function __construct(
        DateTime $date,
        Template\Context $context,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->date = $date;
        $this->registry = $registry;
    }

    /**
     * Get product.
     * 
     * @return Product
     */
    public function getProduct(): Product
    {
        if ($this->product === null) {
            $this->product = $this->registry->registry('product');
        }

        return $this->product;
    }

    /**
     * Get gmt date.
     * 
     * @return string
     */
    public function getDate(): string
    {
        return $this->date->gmtDate();
    }
}
