<?php

namespace Realworld\Domain\Exception\User;

use Realworld\Domain\Exception\DomainExceptionInterface;

class FollowingNotFoundException extends \DomainException implements DomainExceptionInterface
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if ($message === "") {
            $message = "Following not found";
        }

        parent::__construct($message, $code, $previous);
    }
}