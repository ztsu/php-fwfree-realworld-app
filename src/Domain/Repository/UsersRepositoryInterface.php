<?php

namespace Realworld\Domain\Repository;

use Realworld\Domain\Model\User;

/**
 * Repository for users (interface)
 */
interface UsersRepositoryInterface
{
    public function add(User $user): int;

    public function getUserByEmail(string $email): User;

    public function getByName(string $name): User;

    public function getById(int $id): User;

    public function hasUserWithEmail(string $email): bool;

    public function hasUserWithName(string $name): bool;
}