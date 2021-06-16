<?php
declare(strict_types=1);

namespace Test\GetPrice\Helper;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class CustomData extends AbstractHelper
{
    const ENABLE_SHOW_PRICE = 'get_price/general/enable_module';
    const SHOW_BASE_PRICE = 'get_price/general/show_base_price';
    const SHOW_FINAL_PRICE = 'get_price/general/show_final_price';
    const SHOW_SPECIAL_PRICE = 'get_price/general/show_special_price';
    const SHOW_TIER_PRICE = 'get_price/general/show_tier_price';
    const SHOW_CATALOG_PRICE = 'get_price/general/show_catalog_price';

    /** @var ConfigInterface */
    private $configInterface;

    public function __construct(
        Context $context,
        ConfigInterface $configInterface
    ) {
        parent::__construct($context);
        $this->configInterface = $configInterface;
    }

    public function getEnableModule()
    {
        return $this->scopeConfig->getValue(
            self::ENABLE_SHOW_PRICE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function setDisbleFields()
    {
        $this->configInterface
            ->saveConfig($this::SHOW_BASE_PRICE,
                false,
                'default', 0);
        $this->configInterface
            ->saveConfig($this::SHOW_FINAL_PRICE,
                false,
                'default', 0);
        $this->configInterface
            ->saveConfig($this::SHOW_SPECIAL_PRICE,
                false,
                'default', 0);
        $this->configInterface
            ->saveConfig($this::SHOW_TIER_PRICE,
                false,
                'default', 0);
        $this->configInterface
            ->saveConfig($this::SHOW_CATALOG_PRICE,
                false,
                'default', 0);
    }

    /**
     * @return bool
     */
    public function showBasePrice(): bool
    {
        return $this->isVisible(self::SHOW_BASE_PRICE);
    }

    /**
     * @return bool
     */
    public function showFinalPrice(): bool
    {
        return $this->isVisible(self::SHOW_FINAL_PRICE);
    }

    /**
     * Is special price visible.
     *
     * @return bool
     */
    public function showSpecialPrice(): bool
    {
        return $this->isVisible(self::SHOW_SPECIAL_PRICE);
    }

    /**
     * @return bool
     */
    public function showTierPrice(): bool
    {
        return $this->isVisible(self::SHOW_TIER_PRICE);
    }

    public function showCatalogPrice(): bool
    {
        return $this->isVisible(self::SHOW_CATALOG_PRICE);
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isVisible(string $type): bool
    {
        return $this->scopeConfig->isSetFlag(
            $type,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
