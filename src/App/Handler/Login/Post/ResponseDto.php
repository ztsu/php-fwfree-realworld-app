<?php

namespace Realworld\App\Handler\Login\Post;

use Psr\Http\Message\ResponseInterface;
use Realworld\App\Common\ResponseDto\AuthenticatedUserResponseDto;

/**
 * Data for response on POST request to /api/users/login
 */
class ResponseDto implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param AuthenticatedUserResponseDto $user
     */
    public function __construct(AuthenticatedUserResponseDto $user)
    {
        $this->data["user"] = $user;
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
        $response->getBody()->write(json_encode($this));

        return $response;
    }
}