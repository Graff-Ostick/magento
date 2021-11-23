<?php
declare(strict_types=1);

namespace Test\Name\Model\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Test\Name\Logger\Logger;

class CustomerRegister implements ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_support/email';
    /** @var CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var Logger */
    private $_logger;

    /** @var TransportBuilder */
    private $_transportBuilder;

    /** @var StateInterface */
    private $inlineTranslation;

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var Escaper */
    private $_escaper;

    /** @var LoggerInterface */
    private $psrLogger;

    /**
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Escaper $escaper
     * @param CustomerRepositoryInterface $customerRepository
     * @param LoggerInterface $psrLogger
     * @param Logger $logger
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $psrLogger,
        Logger $logger
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->customerRepository = $customerRepository;
        $this->psrLogger = $psrLogger;
        $this->_logger = $logger;
    }

    /**
     * remove spaces in customer_entity table in firstname column
     * @param Observer $observer
     * @throws InputException
     * @throws LocalizedException
     * @throws InputMismatchException
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $data = [
            'created_at' => $customer->getCreatedat(),
            "firstname" => $customer->getFirstname(),
            "lastname" => $customer->getLastname(),
            "email" => $customer->getEmail()
        ];
        $customerName = $customer->getFirstname();
        $customer->setFirstname(preg_replace('/\s+/', '', $customerName));
        $this->customerRepository->save($customer);
        $this->log($data);
        $this->sendEmail($observer);
    }

    /**
     * log data in file '/var/log/registeredCustomers.log'
     * @param $data
     */
    public function log($data){
        $this->_logger->info(json_encode($data));
    }

    /**
     * sen email to customer support
     * @param $observer
     */
    public function sendEmail($observer){
        $customer = $observer->getData('customer');
        $this->inlineTranslation->suspend();

        try
        {

            $sender = [
                'name' => $this->_escaper->escapeHtml($customer->getFirstName()),
                'lastName' => $this->_escaper->escapeHtml($customer->getLastName()),
                'email' => $this->_escaper->escapeHtml($customer->getEmail()),
            ];
            $postObject = new DataObject();
            $postObject->setData($sender);
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('customer_registered')
                ->setTemplateOptions(
                    ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,]
                )
                ->setTemplateVars($sender)
                ->setFrom($sender)
                ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
                ->getTransport();
            $transport->sendMessage(); ;
            $this->inlineTranslation->resume();
        }
        catch (\Exception $e)
        {
            $this->psrLogger->debug($e->getMessage());
        }
    }
}
