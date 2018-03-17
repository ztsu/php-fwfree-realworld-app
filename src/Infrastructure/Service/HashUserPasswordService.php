<?php

namespace Realworld\Infrastructure\Service;

use Realworld\Domain\Model\Password;
use Realworld\Domain\Model\PasswordHashed;
use Realworld\Domain\Service\HashUserPasswordServiceInterface;

class HashUserPasswordService implements HashUserPasswordServiceInterface
{
    public function hash(Password $password): PasswordHashed
    {
        return new PasswordHashed($password->__toString());
    }
}