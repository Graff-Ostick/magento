<?php
declare(strict_types=1);

namespace Test\RequestPrice\Model\Options\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Status options soruce model.
 */
class Status implements OptionSourceInterface
{
    public const NEW = 'NEW';
    public const IN_PROGRESS = 'In Progress';
    public const CLOSED = 'Closed';

    /**
     * @inheirtDoc
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::NEW,
                'label' => __('New')
            ],
            [
                'value' => self::IN_PROGRESS,
                'label' => __('In Progress')
            ],
            [
                'value' => self::CLOSED,
                'label' => __('Closed')
            ]
        ];
    }
}
