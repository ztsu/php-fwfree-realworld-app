<?php

namespace Realworld\Domain\Model;

use Realworld\Domain\Exception\InvalidArgumentException;

/**
 * User
 */
class User
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $passwordHash;

    /**
     * @var string
     */
    public $bio;

    /**
     * @var string
     */
    public $image;

    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $passwordHash
     * @param string $bio
     * @param string $image
     */
    public function __construct(int $id, string $name, string $email, string $passwordHash, string $bio, string $image)
    {
        $this->id = $id;
        $this->setName($name);
        $this->setEmail($email);
        $this->setPasswordHash($passwordHash);
        $this->bio = $bio;
        $this->image = $image;

    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $bio
     * @param string $image
     * @return User
     */
    public static function create(string $name, string $email, string $password, string $bio = "", string $image = ""): self
    {
        return new self(0, $name, $email, self::hashPassword($password), $bio, $image);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function comparePassword(string $password): bool
    {
        return $this->passwordHash === $this->hashPassword($password);
    }

    public function follow(User $user): Following
    {
        return new Following($user->id, $this->id);
    }

    /**
     * @param string $name
     */
    private function setName(string $name)
    {
        if ($name === "") {
            throw new InvalidArgumentException(
                sprintf(
                    "User cannot be without a name"
                )
            );
        }

        $this->name = $name;
    }

    /**
     * @param string $email
     */
    private function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf("\"%s\" is not valid email", $email)
            );
        }

        $this->email = $email;
    }

    /**
     * @param string $passwordHash
     */
    private function setPasswordHash(string $passwordHash)
    {
        if ($passwordHash === self::hashPassword("")) {
            throw new InvalidArgumentException("User cannot have an empty password");
        }

        $this->passwordHash = $passwordHash;
    }

    /**
     * @param string $password
     * @return string
     */
    private static function hashPassword(string $password): string
    {
        return md5($password);
    }
}