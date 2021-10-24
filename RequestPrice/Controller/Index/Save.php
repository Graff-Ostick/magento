<?php

namespace Test\RequestPrice\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Test\RequestPrice\Model\RequestPriceFactory;

class Save extends Action
{

    /**
     * @var RequestPriceFactory
     */
    protected $requestPrice;

    public function __construct(
        Context $context,
        RequestPriceFactory $requestPrice
    ) {
        $this->requestPrice = $requestPrice;
        parent::__construct($context);
    }
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $requestPrice = $this->requestPrice->create();
        $requestPrice->setData($data);
        if ($requestPrice->save()) {
            $this->messageManager->addSuccessMessage(__('You saved request'));
        } else {
            $this->messageManager->addErrorMessage(__('Request was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('request_price/index/index');
        return $resultRedirect;
    }
}
