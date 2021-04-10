<?php
namespace Test\Obsplug\Controller\Adminhtml\MyPage;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Check if user has enough privileges
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_ObsPlug::mypage');
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        $this->_setActiveMenu('Test_ObsPlug::mypage');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('My Admin Page'));

        $this->_addBreadcrumb(__('Stores'), __('Stores'));
        $this->_addBreadcrumb(__('My Admin Page'), __('My Admin Page'));

        $this->_view->renderLayout();
    }
}
