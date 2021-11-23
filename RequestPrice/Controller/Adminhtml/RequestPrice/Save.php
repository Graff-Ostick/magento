<?php
declare(strict_types=1);

namespace Test\RequestPrice\Controller\Adminhtml\RequestPrice;

use Magento\Backend\App\Action\Context;
use Test\RequestPrice\Model\RequestPriceFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Save action.
 */
class Save extends Action implements HttpPostActionInterface
{
    private const RESOURCE = 'Test_RequestPrice::save';

    /** @var RequestPriceFactory */
    private $gridFactory;

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
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('adminpage/requestprice/addrow');
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

        return $this->_redirect('adminpage/requestprice/index');
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::RESOURCE);
    }
}
