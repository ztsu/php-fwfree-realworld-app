<?php

namespace Realworld\Domain\Service\User;

use Realworld\Domain\Repository\FollowingsRepositoryInterface;

/**
 * Service for checking following that the user followed by another user
 */
class CheckUserFollowedByUserService
{
    /**
     * @var FollowingsRepositoryInterface
     */
    private $followings;

    /**
     * @param FollowingsRepositoryInterface $followings
     */
    public function __construct(FollowingsRepositoryInterface $followings)
    {
        $this->followings = $followings;
    }

    /**
     * @param int $followerUserId
     * @param int $followedUserId
     * @return bool
     */
    public function check(int $followerUserId, int $followedUserId): bool
    {
        $this->followings->getByUserId($followerUserId, $followedUserId);

        return true;
    }
}