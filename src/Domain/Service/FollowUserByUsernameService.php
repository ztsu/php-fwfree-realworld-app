<?php

namespace Realworld\Domain\Service;

use Realworld\Domain\Model\Following;
use Realworld\Domain\Repository\FollowingsRepositoryInterface;
use Realworld\Domain\Repository\UsersRepositoryInterface;

class FollowUserByUsernameService
{
    /**
     * @var UsersRepositoryInterface
     */
    private $users;

    /**
     * @var FollowingsRepositoryInterface
     */
    private $followings;

    /**
     * @param UsersRepositoryInterface $users
     * @param FollowingsRepositoryInterface $followings
     */
    public function __construct(UsersRepositoryInterface $users, FollowingsRepositoryInterface $followings)
    {
        $this->users = $users;
        $this->followings = $followings;
    }

    /**
     * @param string $toFollowUserName
     * @param int $userId
     * @return Following
     */
    public function run(string $toFollowUserName, int $userId): Following
    {
        $follower = $this->users->getById($userId);

        $userToFollow = $this->users->getByName($toFollowUserName);

        $following = $follower->follow($userToFollow);

        $this->followings->add($following);

        return $following;
    }
}