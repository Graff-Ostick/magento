<?php
namespace Test\Batut\Block;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoresConfig;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends \Magento\Framework\View\Element\Template
{
    private $config;

    public function __construct(Template\Context $context, ScopeConfigInterface $config, array $data = [])
    {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->config->getValue('helloworld/general/enable', ScopeConfigInterface::SCOPE_TYPE_DEFAULT );
    }

}
