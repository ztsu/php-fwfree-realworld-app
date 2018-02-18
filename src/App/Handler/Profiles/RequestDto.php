<?php

namespace Realworld\App\Handler\Profiles;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Data from GET request to /api/profiles/:username
 */
class RequestDto
{
    /**
     * @var string
     */
    public $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param ServerRequestInterface $request
     * @return RequestDto
     */
    public static function create(ServerRequestInterface $request): self
    {
        return new self($request->getAttribute("username", ""));
    }
}