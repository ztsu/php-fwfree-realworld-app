<?php

namespace Realworld\App\Common\ResponseDto;
use Realworld\Domain\Model\User;

/**
 * Profile (DTO for responses)
 */
class ProfileResponseDto implements \JsonSerializable
{
    /**
     * @var array
     */
    private $profile = [];

    /**
     * @param $username
     * @param $bio
     * @param $image
     * @param $following
     */
    public function __construct(string $username, string $bio, string $image, bool $following)
    {
        $this->profile = [
            "username" => $username,
            "bio" => $bio,
            "image" => $image,
            "following" => $following,
        ];
    }

    /**
     * @param User $user
     * @param bool $following
     * @return ProfileResponseDto
     */
    public static function create(User $user, bool $following): self
    {
        return new self($user->name, $user->bio, $user->image, $following);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->profile;
    }
}