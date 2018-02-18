<?php

namespace Realworld\Domain\Service\User;

use Realworld\Domain\Exception\DomainExceptionInterface;

class UserNotFoundException extends \DomainException implements DomainExceptionInterface
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if ($message === "") {
            $message = "User not found";
        }

        parent::__construct($message, $code, $previous);
    }
}