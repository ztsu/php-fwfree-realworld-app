<?php

namespace Realworld\App\Handler\ProfilesFollowings\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\App\Handler\HandlerInterface;

/**
 * Handles DELETE /api/profiles/:username/follow
 */
class ProfilesFollowingsDeleteHandler implements HandlerInterface
{
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response = $response->withStatus(StatusCodeInterface::STATUS_NOT_IMPLEMENTED);

        return $response;
    }
}