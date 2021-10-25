<?php
declare(strict_types=1);

namespace Test\RequestPrice\Block\Adminhtml\Grid;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Magento\Framework\Phrase;

/**
 * ...
 */
class AddRow extends Container
{
    private const RESOURCE = 'Test_RequestPrice::add_row';
    private const FORM_ACTION_URL = 'form_action_url';

    /** @var Registry */
    protected $_coreRegistry;

    /**
     * @param Context  $context
     * @param Registry $registry
     * @param array    $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_objectId = 'row_id';
        $this->_blockGroup = 'Test_RequestPrice';
        $this->_controller = 'adminhtml_grid';

        parent::_construct();

        if ($this->_isAllowedAction(self::RESOURCE)) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }
        $this->buttonList->remove('reset');
    }

    /**
     * Retrieve text for header element depending on loaded image.
     *
     * @return Phrase
     */
    public function getHeaderText(): Phrase
    {
        return __('Add RoW Data');
    }

    /**
     * Check permission for passed action.
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction(string $resourceId): bool
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Get form action URL.
     *
     * @return string
     */
    public function getFormActionUrl(): string
    {
        return $this->_getData(self::FORM_ACTION_URL) ?? $this->getUrl('*/*/save');
    }
}
