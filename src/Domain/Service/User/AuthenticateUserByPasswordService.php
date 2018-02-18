<?php

namespace Realworld\Domain\Service\User;

use Realworld\Domain\Model\User;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Service\User\WrongPasswordException;

class AuthenticateUserByPasswordService
{
    /**
     * @var UsersRepositoryInterface
     */
    private $users;

    /**
     * @param UsersRepositoryInterface $users
     */
    public function __construct(
        UsersRepositoryInterface $users
    ) {
        $this->users = $users;
    }

    public function authenticate(string $email, string $password): User
    {
        $user = $this->users->getUserByEmail($email);

        if (!$user->comparePassword($password)) {
            throw new WrongPasswordException();
        }

        return $user;
    }
}