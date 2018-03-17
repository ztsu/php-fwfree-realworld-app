<?php

namespace Realworld\Infrastructure\Repository;

use Realworld\Domain\Exception\FollowingNotFoundException;
use Realworld\Domain\Model\Following;
use Realworld\Domain\Repository\FollowingsRepositoryInterface;

class FollowingsRepository implements FollowingsRepositoryInterface
{
    private $db;

    public function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function add(Following $following): Following
    {
        $statement = $this->db->prepare(
            "INSERT INTO `followings` (`followerUserId`, `followedUserId`) VALUES (?, ?)"
        );

        $statement->execute([$following->followerUserId, $following->followedUserId]);

        return $following;
    }

    public function getByUserId(int $followerUserId, int $followedUserId): Following
    {
    }
}