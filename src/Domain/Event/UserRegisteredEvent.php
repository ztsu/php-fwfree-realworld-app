<?php

namespace Realworld\Domain\Event;

class UserRegisteredEvent implements EventInterface
{
    public function __toString()
    {
        return __CLASS__;
    }
}