<?php

namespace Realworld\App\Handler\User\Get;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\App\Authentication\AuthToken;
use Realworld\App\Authentication\TokenService;
use Realworld\App\Common\ResponseDto\AuthenticatedUserResponseDto;
use Realworld\App\Handler\Exception\BadRequestException;
use Realworld\App\Handler\Exception\UnauthorizedRequestException;
use Realworld\App\Handler\HandlerInterface;
use Realworld\App\Middleware\AuthMiddleware;
use Realworld\Domain\Repository\UsersRepositoryInterface;

/**
 * UserGetHandler handles GET /api/user requests
 */
class UserGetHandler implements HandlerInterface
{
    /**
     * @var TokenService
     */
    private $tokenService;

    /**
     * @var UsersRepositoryInterface
     */
    private $users;

    /**
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService, UsersRepositoryInterface $users)
    {
        $this->tokenService = $tokenService;
        $this->users = $users;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws BadRequestException
     * @throws UnauthorizedRequestException
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /**
         * @var $encodedToken AuthToken
         */
        $token = $request->getAttribute(AuthMiddleware::ATTR_NAME);
        if ($token == null) {
            throw new UnauthorizedRequestException();
        }

        $user = $this->users->getByName($token->name);

        try {
            $encodedToken = $this->tokenService->encode($token);

        } catch (\Throwable $throwable) {
            throw new BadRequestException();
        }

        $response = (new ResponseDto(AuthenticatedUserResponseDto::create($user, $encodedToken)))->writeTo($response);

        return $response;
    }
}