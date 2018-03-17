<?php

namespace Realworld\Domain\UseCases;

use Realworld\Domain\Model\User;
use Realworld\Domain\Service\CreateUserService;
use Realworld\Domain\Service\HashUserPasswordServiceInterface;

class UserRegister
{
    private $hashUserPasswordService;

    private $createUserService;

    public function __construct(HashUserPasswordServiceInterface $hashUserPasswordService, CreateUserService $createUserService)
    {
        $this->hashUserPasswordService = $hashUserPasswordService;
        $this->createUserService = $createUserService;
    }

    public function register(string $name, string $email, string $password, string $bio, string $image): User
    {
        $passwordHash = $this->hashUserPasswordService->hash($password);

        $user = User::create($name, $email, $passwordHash->__toString(), $bio, $image);

        $result = $this->createUserService->create($user);

        return $result;
    }
}