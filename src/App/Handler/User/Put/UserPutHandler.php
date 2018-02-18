<?php

namespace Realworld\App\Handler\User\Put;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\App\Handler\Exception\UnauthorizedRequestException;
use Realworld\App\Handler\HandlerInterface;
use Realworld\App\Middleware\AuthMiddleware;

/**
 * Handles request PUT /api/user
 */
class UserPutHandler implements HandlerInterface
{
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /**
         * @var $encodedToken AuthToken
         */
        $token = $request->getAttribute(AuthMiddleware::ATTR_NAME);
        if ($token == null) {
            throw new UnauthorizedRequestException();
        }

        $response = $response->withStatus(StatusCodeInterface::STATUS_NOT_IMPLEMENTED);

        return $response;
    }
}