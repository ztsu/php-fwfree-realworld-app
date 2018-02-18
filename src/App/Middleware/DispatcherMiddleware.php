<?php

namespace Realworld\App\Middleware;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Realworld\App\Handler\HandlerFactory;
use Realworld\App\Handler\Login\Post\LoginPostHandler;
use Realworld\App\Handler\Profiles\ProfilesGetHandler;
use Realworld\App\Handler\ProfilesFollowings\Delete\ProfilesFollowingsDeleteHandler;
use Realworld\App\Handler\ProfilesFollowings\Post\ProfilesFollowingsPostHandler;
use Realworld\App\Handler\User\Get\UserGetHandler;
use Realworld\App\Handler\User\Put\UserPutHandler;
use Realworld\App\Handler\Users\Post\UsersPostHandler;
use Zend\Diactoros\Response;

/**
 * Dispatcher middleware
 *
 * Dispatches a request to an appropriate handler
 */
class DispatcherMiddleware implements MiddlewareInterface
{
    /**
     * @var Dispatcher
     */
    private $router;

    /**
     * @var HandlerFactory
     */
    private $handlerFactory;

    /**
     * @param HandlerFactory $factory
     */
    public function __construct(HandlerFactory $factory)
    {
        $routing = [
            [RequestMethodInterface::METHOD_POST, "/api/users/login", LoginPostHandler::class],
            [RequestMethodInterface::METHOD_POST, "/api/users", UsersPostHandler::class],
            [RequestMethodInterface::METHOD_GET, "/api/user", UserGetHandler::class],
            [RequestMethodInterface::METHOD_PUT, "/api/user", UserPutHandler::class],
            [RequestMethodInterface::METHOD_GET, "/api/profiles/{username}", ProfilesGetHandler::class],
            [RequestMethodInterface::METHOD_POST, "/api/profiles/{username}/follow", ProfilesFollowingsPostHandler::class],
            [RequestMethodInterface::METHOD_DELETE, "/api/profiles/{username}/follow", ProfilesFollowingsDeleteHandler::class],
        ];

        $this->router = \FastRoute\simpleDispatcher(
            function(RouteCollector $router) use ($routing) {

                foreach ($routing as $route) {
                    list($method, $path, $handler) = $route;
                    $router->addRoute($method, $path, $handler);
                }
            }
        );

        $this->handlerFactory = $factory;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new Response();

        $result = $this->router->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($result[0]) {
            case Dispatcher::NOT_FOUND:
                $response = $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $response = $response->withStatus(StatusCodeInterface::STATUS_METHOD_NOT_ALLOWED);
                break;

            case Dispatcher::FOUND:
                foreach ($result[2] as $key => $param) {
                    $request = $request->withAttribute($key, $param);
                }

                $response = $this->handlerFactory->create($result[1])->handle($request, $response);

                break;
        }

        return $response;
    }
}