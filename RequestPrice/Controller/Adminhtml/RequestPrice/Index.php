<?php
declare(strict_types=1);

namespace Test\RequestPrice\Controller\Adminhtml\RequestPrice;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index action.
 */
class Index extends Action implements HttpGetActionInterface
{
    private const RESOURCE = 'Test_RequestPrice::menu';
    private const MENU_ID = 'Test_RequestPrice::menu';

    /** @var PageFactory */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::MENU_ID);

        return $resultPage;
    }

    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::RESOURCE);
    }
}
