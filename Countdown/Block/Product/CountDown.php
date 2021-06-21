<?php
declare(strict_types=1);

namespace Test\Countdown\Block\Product;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\CatalogRule\Model\ResourceModel\Rule;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Store\Model\StoreManagerInterface;
use Test\Quest\Helper\CustomData;
use Psr\Log\LoggerInterface;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;

class CountDown extends Template
{

    /**
     * @var CatalogRuleRepositoryInterface
     */
    private $catalogRuleRepository;
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Rule
     */
    private $rule;

    public function __construct(
        Rule $rule,
        TimezoneInterface $timezone,
        Template\Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        CatalogRuleRepositoryInterface $catalogRuleRepository,
        array $data
    )
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
        $this->timezone = $timezone;
        $this->storeManager = $storeManager;
        $this->rule = $rule;
        $this->catalogRuleRepository = $catalogRuleRepository;
        $this->logger = $logger;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function timeLeft(){
        $endTime = strtotime($this->getProduct()->getSpecialToDate());
        $timeNow = strtotime(date('Y-m-d h:m:s'));
        $left = $endTime-$timeNow;
        return gmdate('d h:m:s', $left);
    }

    public function timeEndSpecialPrice(){
        $specialPrice =  $this->getProduct()->getSpecialToDate();
        $timeNow = strtotime(date('Y-m-d h:m:s'));
        if (strtotime($specialPrice)>$timeNow){
            return $specialPrice;
        }
        else{
            return null;
        }
    }

    public function timeEndCatalogPrice(){
        $productId = $this->getProduct()->getId();
        $date = $this->timezone->date()->getTimestamp();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customerGroupId = $this->getCustomerGroupId();
        $rules = $this->rule->getRulesFromProduct($date, $websiteId, $customerGroupId, $productId);
        if ($rules != null){
            $firstTimeEnd = $rules[0]['to_time'];

            foreach ($rules as $rule){
                if ((int)$rule['to_time']<(int)$firstTimeEnd){
                    $firstTimeEnd = $rule['to_time'];
                }
            }

            return gmdate('Y-m-d h:m:s', (int)$firstTimeEnd);
        }
        else {
            return null;
        }
    }

    public function getFirstEndTime(){
        $catalogTime = $this->timeEndCatalogPrice();
        $specialTime = $this->timeEndSpecialPrice();
        if ($catalogTime!=null && $specialTime!=null){
            return min($catalogTime, $specialTime);
        }
        elseif ($specialTime!=null){
            return $specialTime;
        }
        else{
            return $catalogTime;
        }
    }

    public function getTests(){
        $specialPrice = ['special price ', $this->getProduct()->getSpecialToDate()];
        $productId = $this->getProduct()->getId();
        $date = $this->timezone->date()->getTimestamp();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customerGroupId = $this->getCustomerGroupId();
        $rules = $this->rule->getRulesFromProduct($date, $websiteId, $customerGroupId, $productId);
        $allTime = [];
        $allTime[0] = $specialPrice;
        foreach ($rules as $rule){
            array_push($allTime, [$this->getRuleNameById($rule['rule_id']),gmdate('Y-m-d h:m:s', (int)$rule['to_time'])]);
        }

        return $allTime;
    }

    public function getRuleNameById($ruleId){
        try {
            $rule = $this->catalogRuleRepository->get($ruleId)->getName();
        } catch (NoSuchEntityException $exception) {
            $this->logger($exception->getMessage());
            $rule = null;
        }

        return $rule;
    }
}
