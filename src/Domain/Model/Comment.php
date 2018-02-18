<?php

namespace Realworld\Domain\Model;

/**
 * Article comment
 */
class Comment
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \DateTime
     */
    public $updatedAt;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $authorUserId;

    /**
     * @var int
     */
    public $articleId;
}