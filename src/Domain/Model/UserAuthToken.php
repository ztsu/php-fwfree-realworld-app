<?php

namespace  Realworld\Domain\Model;

use Realworld\Domain\Model\User;

/**
 * Data for authentication token
 */
class UserAuthToken
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @param string $name
     * @param string $email
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @param User $user
     * @return UserAuthToken
     */
    public static function create(User $user): self
    {
        return new self($user->name, $user->email);
    }
}