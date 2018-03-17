<?php

namespace Realworld\Domain\Service;

use Realworld\Domain\Model\UserAuthToken;

interface AuthTokenCoderServiceInterface
{
    public function encode(UserAuthToken $token): string;

    public function decode(string $token): UserAuthToken;
}