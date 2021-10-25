<?php
declare(strict_types=1);

namespace Test\RequestPrice\Controller\Index;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Validator\EmailAddress;
use Magento\Framework\Validator\NotEmpty;
use Test\RequestPrice\Model\RequestPriceFactory;
use Test\RequestPrice\Model\ResourceModel\RequestPrice as RequestPriceResource;
use Zend_Validate;

/**
 * Save action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /** @var RequestPriceFactory */
    protected $requestPrice;

    /** @var JsonFactory */
    private $jsonFactory;

    /** @var RequestPriceResource */
    private $requestPriceResource;

    /**
     * @param Context $context
     * @param RequestPriceFactory $requestPrice
     * @param JsonFactory $jsonFactory
     * @param RequestPriceResource $requestPriceResource
     */
    public function __construct(
        Context $context,
        RequestPriceFactory $requestPrice,
        JsonFactory $jsonFactory,
        RequestPriceResource $requestPriceResource
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->requestPrice = $requestPrice;
        $this->requestPriceResource = $requestPriceResource;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $requestPrice = $this->requestPrice->create();
        try {
            $messages=$this->validate($data);
            if (!$messages) {
                $requestPrice->setData($data);
                $this->requestPriceResource->save($requestPrice);
                $data = [
                    'success' => true,
                    'message' => __('You saved request')
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => implode(' ', $messages)
                ];
            }
        } catch (Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Request was not saved.')
            ];
        }
        $result = $this->jsonFactory->create();

        return $result->setData($data);
    }

    /**
     * Validate.
     *
     * @param array $data
     *
     * @return array
     * @throws Exception
     */
    private function validate(array $data): array
    {
        $messages = [];
        if (!Zend_Validate::is($data['email'], EmailAddress::class)) {
            $messages[] = __('Email is invalid');
        }
        if (!Zend_Validate::is($data['name'], NotEmpty::class)) {
            $messages[] = __('Name is invalid');
        }

        return $messages;
    }
}
