<?php

namespace Realworld\Domain\Exception;

class PasswordIsTooShortException extends \DomainException implements DomainExceptionInterface
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if ($message === "") {
            $message = "Short password";
        }

        parent::__construct($message, $code, $previous);
    }
}