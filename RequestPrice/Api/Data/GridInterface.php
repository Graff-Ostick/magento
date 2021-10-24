<?php

namespace Test\RequestPrice\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array.
     */
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const COMMENT = 'comment';
    const STATUS = 'status';
    const SKU = 'sku';
    const CREATED_AT = 'created_at';

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set Id.
     */
    public function setId($id);

    /**
     * Get Name.
     *
     * @return varchar
     */
    public function getName();

    /**
     * Set Name.
     */
    public function setName($name);

    /**
     * Get Email.
     *
     * @return varchar
     */
    public function getEmail();

    /**
     * Set Email.
     */
    public function setEmail($email);

    /**
     * Get Comment.
     *
     * @return varchar
     */
    public function getComment();

    /**
     * Set Comment.
     */
    public function setComment($comment);

    /**
     * Get Sku.
     *
     * @return varchar
     */
    public function getSku();

    /**
     * Set Sku.
     */
    public function setSku($sku);

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Status.
     *
     * @return varchar
     */
    public function getStatus();

    /**
     * Set Status.
     */
    public function setStatus($status);

}
