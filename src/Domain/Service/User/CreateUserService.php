<?php

namespace Realworld\Domain\Service\User;

use Realworld\Domain\Model\User;
use Realworld\Domain\Repository\UsersRepositoryInterface;

/**
 * Create user (service)
 */
class CreateUserService
{
    /**
     * @var UsersRepositoryInterface
     */
    private $repository;

    /**
     * @param UsersRepositoryInterface $repository
     */
    public function __construct(UsersRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @return User
     */
    public function create(User $user): User
    {
        if ($this->repository->hasUserWithEmail($user->email)) {
            throw new UserAlreadyExistsException("User `{$user->email}` already exists");
        }

        if ($this->repository->hasUserWithName($user->name)) {
            throw new UserAlreadyExistsException("User `{$user->name}` already exists");
        }

        $id = $this->repository->add($user);

        return new User(
            $id,
            $user->name,
            $user->email,
            $user->passwordHash,
            $user->bio,
            $user->image
        );
    }
}