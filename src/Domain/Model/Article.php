<?php

namespace Realworld\Domain\Model;

/**
 * Article
 */
class Article
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $body;

    /**
     * @var Tag[]
     */
    public $tags;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \DateTime
     */
    public $updatedAt;

    /**
     * @var int
     */
    public $authorId;
}