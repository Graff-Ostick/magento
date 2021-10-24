<?php

namespace Test\RequestPrice\Controller\Adminhtml\RequestPrice;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Test\RequestPrice\Model\RequestPriceFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var RequestPriceFactory
     */
    private $gridFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry,
     * @param RequestPriceFactory $gridFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        RequestPriceFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->gridFactory = $gridFactory;
    }

    /**
     * Mapped Grid List page.
     * @return Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->gridFactory->create();
        /** @var Page $resultPage */
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getName();
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('adminpage/requestprice/rowdata');
                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Row Data ').$rowTitle : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_RequestPrice::add_row');
    }
}
