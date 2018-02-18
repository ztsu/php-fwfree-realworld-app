<?php

namespace Realworld\App\Handler\ProfilesFollowings\Post;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Realworld\App\Common\ResponseDto\ProfileResponseDto;

/**
 * Data for response on POST request to /api/profiles/:username/follow
 */
class ResponseDto implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param ProfileResponseDto $profile
     */
    public function __construct(ProfileResponseDto $profile)
    {
        $this->data["profile"] = $profile;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return $this->data;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function writeTo(ResponseInterface $response)
    {
        $response = $response->withStatus(StatusCodeInterface::STATUS_CREATED);

        $response = $response->withHeader("Content-Type", "application/json");
        $response->getBody()->write(json_encode($this));

        return $response;
    }
}