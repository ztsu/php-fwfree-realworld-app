<?php

namespace Realworld\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Parses body of requests as JSON
 */
class ParseJsonMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $contentType = $request->getHeader("Content-Type");

        if (count($contentType) > 0 && $contentType[0] === "application/json") {
            $request = $request->withParsedBody(
                json_decode($request->getBody()->getContents(), true)
            );
        }

        return $handler->handle($request);
    }
}