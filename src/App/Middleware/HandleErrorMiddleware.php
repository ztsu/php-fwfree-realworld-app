<?php

namespace Realworld\App\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Realworld\App\Handler\Exception\BadRequestException;
use Realworld\App\Handler\Exception\HandlerExceptionInterface;
use Realworld\App\Handler\Exception\UnauthorizedRequestException;
use Realworld\Domain\Exception\DomainExceptionInterface;
use Zend\Diactoros\Response;

/**
 * Error handler middleware
 *
 * Catches exceptions from next middlewares, logs it and returns the response with needed status
 */
class HandleErrorMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);

        } catch (DomainExceptionInterface $exception) {
            $response = new Response();
            $response = $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            $response->getBody()->write($exception->getMessage());

        } catch (HandlerExceptionInterface $exception) {
            $response = new Response();
            $response = $response->withStatus(self::mapHandlerExceptionToHttpStatus($exception));
            $response->getBody()->write($exception->getMessage());

        } catch (\Throwable $throwable) {
            trigger_error($throwable, E_USER_WARNING);

            $response = new Response();
            $response = $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    public static function mapHandlerExceptionToHttpStatus(HandlerExceptionInterface $exception): int
    {
        $mapping = [
            BadRequestException::class => StatusCodeInterface::STATUS_BAD_REQUEST,
            UnauthorizedRequestException::class => StatusCodeInterface::STATUS_UNAUTHORIZED,
        ];

        $className = get_class($exception);

        if (array_key_exists($className, $mapping)) {
            return $mapping[$className];
        }

        return StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR;
    }
}