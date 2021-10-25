<?php
declare(strict_types=1);

namespace Test\RequestPrice\Model;

use Magento\Framework\Model\AbstractModel;
use Test\RequestPrice\Api\Data\RequestPriceInterface;
use Test\RequestPrice\Model\ResourceModel\RequestPrice as RequestPriceResource;

/**
 * Request price model.
 */
class RequestPrice extends AbstractModel implements RequestPriceInterface
{
    const CACHE_TAG = 'request_price';

    /** @var string */
    protected $_cacheTag = 'request_price';

    /** @var string */
    protected $_eventPrefix = 'request_price';

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(RequestPriceResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): RequestPriceInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): ?string
    {
        return $this->_getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(string $email): RequestPriceInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getComment(): ?string
    {
        return $this->_getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment(string $comment): RequestPriceInterface
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * @inheritDoc
     */
    public function getSku(): ?string
    {
        return $this->_getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku(string $sku): RequestPriceInterface
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): RequestPriceInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?string
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): RequestPriceInterface
    {
        return $this->setData(self::STATUS, $status);
    }
}
