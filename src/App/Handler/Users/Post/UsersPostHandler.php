<?php

namespace Realworld\App\Handler\Users\Post;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\App\Authentication\AuthToken;
use Realworld\App\Authentication\TokenService;
use Realworld\App\Common\ResponseDto\AuthenticatedUserResponseDto;
use Realworld\App\Handler\HandlerInterface;
use Realworld\Domain\Service\User\CreateUserService;

/**
 * Handles POST request to /api/users
 */
class UsersPostHandler implements HandlerInterface
{
    /**
     * @var CreateUserService
     */
    private $createUserService;

    /**
     * @var TokenService
     */
    private $encodeTokenService;

    /**
     * @param CreateUserService $service
     */
    public function __construct(CreateUserService $service, TokenService $tokenService)
    {
        $this->createUserService = $service;
        $this->encodeTokenService = $tokenService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $user = $this->createUserService->create(RequestDto::create($request)->toUser());
        $token = $this->encodeTokenService->encode(AuthToken::create($user));

        $response = ResponseDto::create(AuthenticatedUserResponseDto::create($user, $token))->writeTo($response);

        return $response;
    }
}