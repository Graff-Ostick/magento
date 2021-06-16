<?php
namespace Test\GetPrice\Block\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Test\GetPrice\Helper\CustomData;


class Disable extends Field
{

    /**
     * @var CustomData
     */
    private $customData;

    public function __construct(
        Context $context,
        CustomData $customData,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->customData = $customData;
    }

    protected function _getElementHtml(AbstractElement $element)
    {

        if (!$this->customData->getEnableModule()) {
            $element->setDisabled('disabled');
            $this->customData->setDisbleFields();
        }
        return parent::_getElementHtml($element);
    }
}
