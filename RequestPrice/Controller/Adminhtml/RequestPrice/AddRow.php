<?php
declare(strict_types=1);

namespace Test\RequestPrice\Controller\Adminhtml\RequestPrice;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Test\RequestPrice\Model\RequestPriceFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Add row action.
 */
class AddRow extends Action implements HttpGetActionInterface
{
    /** @var Registry */
    private $coreRegistry;

    /** @var RequestPriceFactory */
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
     * @inheritDoc
     */
    public function execute()
    {
        $rowId = (int)$this->getRequest()->getParam('id');
        $rowData = $this->gridFactory->create();
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getName();
            if (!$rowData->getId()) {
                $this->messageManager->addError(__('row data no longer exist.'));

                return $this->_redirect('adminpage/requestprice/rowdata');
            }
        }
        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Row Data ').$rowTitle : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_RequestPrice::add_row');
    }
}
