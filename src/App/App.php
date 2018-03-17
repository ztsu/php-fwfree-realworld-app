<?php

namespace Realworld\App;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Realworld\App\Handler\HandlerFactory;
use Realworld\App\Middleware\AuthMiddleware;
use Realworld\App\Middleware\DispatcherMiddleware;
use Realworld\App\Middleware\HandleErrorMiddleware;
use Realworld\App\Middleware\ParseJsonMiddleware;
use Realworld\Domain\Service\AuthTokenCoderServiceInterface;
use Ztsu\Reacon\Reacon;

/**
 * App
 *
 * Handles a request, composes a response and returns it
 */
class App
{
    /**
     * @var RequestHandlerInterface
     */
    private $requestHandler;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->requestHandler = new Reacon(
            new HandleErrorMiddleware(),
            new ParseJsonMiddleware(),
            new AuthMiddleware($container->get(AuthTokenCoderServiceInterface::class)),
            new DispatcherMiddleware($container->get(HandlerFactory::class))
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        return $this->requestHandler->handle($request);
    }
}