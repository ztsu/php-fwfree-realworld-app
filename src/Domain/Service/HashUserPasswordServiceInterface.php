<?php

namespace Realworld\Domain\Service;

use Realworld\Domain\Model\Password;
use Realworld\Domain\Model\PasswordHashed;

interface HashUserPasswordServiceInterface
{
    public function hash(Password $password): PasswordHashed;
}