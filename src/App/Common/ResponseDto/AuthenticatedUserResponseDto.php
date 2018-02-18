<?php

namespace Realworld\App\Common\ResponseDto;

use Realworld\Domain\Model\User;

/**
 * Authenticated User (DTO for responses)
 */
class AuthenticatedUserResponseDto implements \JsonSerializable
{
    /**
     * @var array
     */
    private $user = [];

    /**
     * @param string $email
     * @param string $username
     * @param string $bio
     * @param string $image
     * @param string $token
     */
    public function __construct(string $email, string $username, string $bio, string $image, string $token)
    {
        $this->user = [
            "email" => $email,
            "token" => $token,
            "username" => $username,
            "bio" => $bio,
            "image" => $image,
        ];
    }

    /**
     * @param User $user
     * @param string $token
     * @return AuthenticatedUserResponseDto
     */
    public static function create(User $user, string $token)
    {
        return new self(
            $user->email,
            $user->name,
            $user->bio,
            $user->image,
            $token
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->user;
    }
}