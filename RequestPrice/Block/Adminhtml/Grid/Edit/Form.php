<?php
declare(strict_types=1);

namespace Test\RequestPrice\Block\Adminhtml\Grid\Edit;

use IntlDateFormatter;
use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Form\Generic;
use Test\RequestPrice\Model\Options\Source\Status as StatusOptions;

/**
 * Adminhtml Add New Row Form.
 */
class Form extends Generic
{
    /** @var Config */
    private $_wysiwygConfig;

    /** @var StatusOptions */
    private $statusOptions;

    /**
     * @param Context       $context
     * @param Registry      $registry
     * @param FormFactory   $formFactory
     * @param Config        $wysiwygConfig
     * @param StatusOptions $statusOptions
     * @param array         $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        StatusOptions $statusOptions,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->statusOptions = $statusOptions;
    }

    /**
     * @inheritDoc
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('rqprice_');
        if ($model->getId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'id' => 'name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'style' => 'width:400px',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'comment',
            'editor',
            [
                'name' => 'comment',
                'label' => __('Comment'),
                'style' => 'height:36em;',
                'title' => __('Comment'),
                'config' => $wysiwygConfig
            ]
        );
        $fieldset->addField(
            'sku',
            'text',
            [
                'name' => 'sku',
                'label' => __('SKU'),
                'style' => 'width:100px',
                'title' => __('SKU'),
            ]
        );
        $fieldset->addField(
            'created_at',
            'date',
            [
                'name' => 'created_at',
                'label' => __('Created At'),
                'date_format' => $dateFormat,
                'time_format' => 'H:mm:ss',
                'class' => 'validate-date validate-date-range date-range-custom_theme-from required-entry',
                'style' => 'width:100px',
            ]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->statusOptions->toOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}