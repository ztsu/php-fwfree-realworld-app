<?php

namespace Realworld\App\Handler\Users\Post;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Realworld\App\Common\ResponseDto\AuthenticatedUserResponseDto;

/**
 * Data for response on POST /api/users request
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
     * @param AuthenticatedUserResponseDto $user
     * @return ResponseDto
     */
    public static function create(AuthenticatedUserResponseDto $user): self
    {
        return new self($user);
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

        $response->getBody()->write(json_encode($this));

        return $response;
    }
}