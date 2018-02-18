<?php

namespace Realworld\App\Handler\User\Get;

use Psr\Http\Message\ResponseInterface;
use Realworld\App\Common\ResponseDto\AuthenticatedUserResponseDto;

/**
 * Data for response on GET request to /api/user
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

    public function jsonSerialize()
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