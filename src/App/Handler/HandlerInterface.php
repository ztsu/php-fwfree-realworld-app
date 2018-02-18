<?php

namespace Realworld\App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Request handler (interface)
 */
interface HandlerInterface
{
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}