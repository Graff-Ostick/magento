<?php

namespace Test\RequestPrice\Model;

use Magento\Framework\Model\AbstractModel;
use Test\RequestPrice\Api\Data\GridInterface;

class RequestPrice extends AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'request_price';

    /**
     * @var string
     */
    protected $_cacheTag = 'request_price';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'request_price';

    /**
     * Initialize resource model.
     */
    public function _construct()
    {
        $this->_init('Test\RequestPrice\Model\ResourceModel\RequestPrice');
    }

    /**
     * Get Id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set Id.
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get Name.
     *
     * @return varchar
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name.
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get Email.
     *
     * @return varchar
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set Email.
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get Comment.
     *
     * @return varchar
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * Set Comment.
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * Get SKU.
     *
     * @return varchar
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * Set SKU.
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get Status.
     *
     * @return varchar
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Status.
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

}
