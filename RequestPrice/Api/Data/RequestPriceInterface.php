<?php
namespace Test\RequestPrice\Api\Data;

/**
 * Request price data interface.
 */
interface RequestPriceInterface
{

    public const MAIN_TABLE = 'request_price';
    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const COMMENT = 'comment';
    public const STATUS = 'status';
    public const SKU = 'sku';
    public const CREATED_AT = 'created_at';

    /**
     * Get id.
     *
     * @return int|string
     */
    public function getId();

    /**
     * Set Id.
     *
     * @param string|int $id
     */
    public function setId($id);

    /**
     * Get Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return RequestPriceInterface
     */
    public function setName(string $name): RequestPriceInterface;

    /**
     * Get Email.
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Set Email.
     *
     * @param string $email
     *
     * @return RequestPriceInterface
     */
    public function setEmail(string $email): RequestPriceInterface;

    /**
     * Get Comment.
     *
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * Set Comment.
     *
     * @param string $comment
     *
     * @return RequestPriceInterface
     */
    public function setComment(string $comment): RequestPriceInterface;

    /**
     * Get Sku.
     *
     * @return string
     */
    public function getSku(): ?string;

    /**
     * Set sku.
     *
     * @param string $sku
     *
     * @return RequestPriceInterface
     */
    public function setSku(string $sku): RequestPriceInterface;

    /**
     * Get CreatedAt.
     *
     * @return string
     */
    public function getCreatedAt(): ?string;

    /**
     * Set CreatedAt.
     *
     * @param string $createdAt
     *
     * @return RequestPriceInterface
     */
    public function setCreatedAt(string $createdAt): RequestPriceInterface;

    /**
     * Get Status.
     *
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * Set Status.
     *
     * @param string $status
     *
     * @return RequestPriceInterface
     */
    public function setStatus(string $status): RequestPriceInterface;
}
