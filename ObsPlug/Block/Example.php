<?php
namespace Test\ObsPlug\Block;

use Magento\Framework\View\Element\Template;

class Example extends Template
{
    /**
     * @var \Test\ObsPlug\Helper\Data
     */
    protected $_myHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Test\ObsPlug\Helper\Data $myHelper,
        array $data = [])
    {
        $this->_myHelper = $myHelper;
        parent::__construct($context, $data);
    }

    public function getHello()
    {
        return $this->_myHelper->upperString("Hello");
    }
}
