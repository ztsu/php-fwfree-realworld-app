<?php

namespace Realworld\Domain\Exception;

class WrongPasswordException extends \DomainException implements DomainExceptionInterface
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if ($message === "") {
            $message = "Wrong password";
        }

        parent::__construct($message, $code, $previous);
    }
}