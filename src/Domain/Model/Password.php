<?php

namespace Realworld\Domain\Model;

class Password
{
    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function __toString()
    {
        return $this->password;
    }
}