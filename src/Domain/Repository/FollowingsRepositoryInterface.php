<?php

namespace Realworld\Domain\Repository;

use Realworld\Domain\Exception\User\FollowingNotFoundException;
use Realworld\Domain\Model\Following;

/**
 * Interface for user followings repository
 */
interface FollowingsRepositoryInterface
{
    /**
     * @param Following $following
     * @return Following
     */
    public function add(Following $following): Following;

    /**
     * @param int $followerUserId
     * @param int $followedUserId
     * @return Following
     * @throws FollowingNotFoundException
     */
    public function getByUserId(int $followerUserId, int $followedUserId): Following;
}