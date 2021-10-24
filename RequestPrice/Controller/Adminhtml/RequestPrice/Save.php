<?php

namespace Test\RequestPrice\Controller\Adminhtml\RequestPrice;

use Magento\Backend\App\Action\Context;
use Test\RequestPrice\Model\RequestPriceFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var RequestPriceFactory
     */
    var $gridFactory;

    /**
     * @param Context $context
     * @param RequestPriceFactory $gridFactory
     */
    public function __construct(
        Context $context,
        RequestPriceFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('adminpage/requestprice/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('adminpage/requestprice/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_RequestPrice::save');
    }
}
