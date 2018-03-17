<?php

namespace Realworld\Infrastructure\Repository;

use Realworld\Domain\Model\User;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Exception\UserNotFoundException;

/**
 * Repository for users (implementation)
 */
class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param User $user
     * @return User
     */
    public function add(User $user): User
    {
        $statement = $this->db->prepare(
            "INSERT INTO `users` (`name`, `email`, `password`, `bio`, `image`) VALUES (?, ?, ?, ?, ?)"
        );

        $statement->execute([$user->name, $user->email, $user->passwordHash, $user->bio, $user->image]);

        $id = $this->db->lastInsertId();

        return new User(
            $id,
            $user->name,
            $user->email,
            $user->passwordHash,
            $user->bio,
            $user->image
        );
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        $statement = $this->db->prepare(
            "SELECT `id`, `name`, `email`, `password`, `bio`, `image` FROM `users` WHERE `email` = ? LIMIT 1"
        );

        $statement->execute([$email]);

        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($user === false) {
            throw new UserNotFoundException();
        }

        return new User(
            (int)$user["id"],
            $user["name"] ?: "",
            $user["email"] ?: "",
            $user["password"] ?: "",
            $user["bio"] ?: "",
            $user["image"] ?: ""
        );
    }

    public function getByName(string $name): User
    {
        $statement = $this->db->prepare(
            "SELECT `id`, `name`, `email`, `password`, `bio`, `image` FROM `users` WHERE `name` = ? LIMIT 1"
        );

        $statement->execute([$name]);

        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($user === false) {
            throw new UserNotFoundException();
        }

        return new User(
            (int)$user["id"],
            $user["name"] ?: "",
            $user["email"] ?: "",
            $user["password"] ?: "",
            $user["bio"] ?: "",
            $user["image"] ?: ""
        );
    }

    public function getById(int $id): User
    {
        $statement = $this->db->prepare(
            "SELECT `id`, `name`, `email`, `password`, `bio`, `image` FROM `users` WHERE `id` = ? LIMIT 1"
        );

        $statement->execute([$id]);

        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($user === false) {
            throw new UserNotFoundException();
        }

        return new User(
            (int)$user["id"],
            $user["name"] ?: "",
            $user["email"] ?: "",
            $user["password"] ?: "",
            $user["bio"] ?: "",
            $user["image"] ?: ""
        );
    }


    /**
     * @param string $email
     * @return bool
     */
    public function hasUserWithEmail(string $email): bool
    {
        $statement = $this->db->prepare(
            "SELECT COUNT(id) FROM `users` WHERE `email` = ?"
        );

        $statement->execute([$email]);

        $count = (int)$statement->fetch(\PDO::FETCH_COLUMN);

        return $count > 0;
    }


    /**
     * @param string $name
     * @return bool
     */
    public function hasUserWithName(string $name): bool
    {
        $statement = $this->db->prepare(
            "SELECT COUNT(id) FROM `users` WHERE `name` = ?"
        );

        $statement->execute([$name]);

        $count = (int)$statement->fetch(\PDO::FETCH_COLUMN);

        return $count > 0;
    }
}