<?php
namespace Test\RequestPrice\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;

class RequestPrice extends Template
{
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var Product
     */
    protected $product;

    /**
     * ProductView constructor.
     * @param Template\Context $context
     * @param array $data
     * @param Registry $registry
     */
    public function __construct(
        DateTime $date,
        Template\Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->date = $date;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if ($this->product === null) {
            $this->product = $this->registry->registry('product');
        }

        return $this->product;
    }

    public function getDate()
    {
        return $this->date->gmtDate();
    }
}
