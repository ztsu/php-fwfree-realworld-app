<?php

namespace Realworld\Domain\Model;

/**
 * Following
 */
class Following
{
    /**
     * @var int
     */
    public $followedUserId;

    /**
     * @var int
     */
    public $followerUserId;

    /**
     * @param int $followedUserId
     * @param int $followerUserId
     */
    public function __construct(int $followedUserId, int $followerUserId)
    {
        $this->followerUserId = $followerUserId;
        $this->followedUserId = $followedUserId;
    }

    /**
     * @param User $followedUser
     * @param User $follower
     * @return Following
     */
    public static function create(User $followedUser, User $follower): self
    {
        return new self($followedUser->id, $follower->id);
    }
}