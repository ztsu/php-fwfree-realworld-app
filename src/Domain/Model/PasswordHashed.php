<?php

namespace Realworld\Domain\Model;

class PasswordHashed
{
    private $hashed;

    public function __construct(string $hashed)
    {
        $this->hashed = $hashed;
    }

    public function __toString()
    {
        return $this->hashed;
    }
}