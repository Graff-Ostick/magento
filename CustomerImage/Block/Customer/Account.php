<?php

namespace Test\CustomerImage\Block\Customer;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Test\CustomerImage\Helper\Data;

class Account extends Template
{
    protected $urlBuilder;
    protected $customerSession;
    protected $_customerSession;
    protected $storeManager;
    protected $customerModel;
    protected $helper;
    protected $customerRepositoryInterface;

    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        SessionFactory $customerSession,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Customer $customerModel,
        Data $helper,
        array $data = []
    )
    {
        $this->urlBuilder  = $urlBuilder;
        $this->_customerSession = $customerSession;
        $this->customerSession = $customerSession->create();
        $this->storeManager = $storeManager;
        $this->httpContext = $httpContext;
        $this->customerModel = $customerModel;
        $this->session = $session;
        $this->helper = $helper;

        parent::__construct($context, $data);

        $collection = $this->getContracts();
        $this->setCollection($collection);
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    public function getMediaUrl()
    {
        $baseUrl = $this->getBaseUrl();
        $findme = 'index.php/';
        $pos = strpos($baseUrl, $findme);
        $baseUrl = substr($baseUrl, 0, $pos) . 'media/';
        return $baseUrl;
    }

    public function getCustomerImageUrl($filePath)
    {
        return $this->getMediaUrl() . 'customer' . $filePath;
    }

    public function getFileUrl()
    {
        if (!empty($customerData = $this->customerModel->load($this->customerSession->getId()))){
            $url = $customerData->getData('customer_image');
        }else{
            $url = $this->customerSession->getData('customer_image');
        }
        if (!empty($url)) {
            return $this->getCustomerImageUrl($url);
        }
        return false;
    }
    public function customerLoggedIn()
    {
        if ($this->customerSession->isLoggedIn()) {
            return true;
        } else {
            return false;
        }
    }
    public function getPictureSize()
    {
        $w = $this->helper->getGeneralConfig('width');
        $h = $this->helper->getGeneralConfig('height');
        return [$w, $h];
    }
}
