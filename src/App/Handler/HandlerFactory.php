<?php

namespace Realworld\App\Handler;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use Realworld\App\Authentication\TokenService;
use Realworld\App\Handler\Login\Post\LoginPostHandler;
use Realworld\App\Handler\Profiles\ProfilesGetHandler;
use Realworld\App\Handler\ProfilesFollowings\Delete\ProfilesFollowingsDeleteHandler;
use Realworld\App\Handler\ProfilesFollowings\Post\ProfilesFollowingsPostHandler;
use Realworld\App\Handler\User\Get\UserGetHandler;
use Realworld\App\Handler\User\Put\UserPutHandler;
use Realworld\App\Handler\Users\Post\UsersPostHandler;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Service\User\AuthenticateUserByPasswordService;
use Realworld\Domain\Service\User\CheckUserFollowedByUserService;
use Realworld\Domain\Service\User\CreateUserService;
use Realworld\Domain\Service\User\FollowUserByUsernameService;

/**
 * Handler factory
 *
 * Creates a handler by its class name
 */
class HandlerFactory
{
    /**
     * @var Container
     */
    private $handlers;

    /**
     * @param ContainerInterface $services
     */
    public function __construct(ContainerInterface $services)
    {
        $this->handlers = new Container();

        $this->handlers->add(
            LoginPostHandler::class,
            function () use ($services) {
                return new LoginPostHandler(
                    $services->get(AuthenticateUserByPasswordService::class),
                    $services->get(TokenService::class)
                );
            }
        );

        $this->handlers->add(
            UsersPostHandler::class,
            function() use ($services) {
                return new UsersPostHandler(
                    $services->get(CreateUserService::class),
                    $services->get(TokenService::class)
                );
            }
        );

        $this->handlers->add(
            UserGetHandler::class,
            function() use ($services) {
                return new UserGetHandler(
                    $services->get(TokenService::class),
                    $services->get(UsersRepositoryInterface::class)
                );
            }
        );

        $this->handlers->add(
            UserPutHandler::class,
            function() {
                return new UserPutHandler();
            }
        );

        $this->handlers->add(
            ProfilesGetHandler::class,
            function() use ($services) {
                return new ProfilesGetHandler(
                    $services->get(CheckUserFollowedByUserService::class)
                );
            }
        );

        $this->handlers->add(
            ProfilesFollowingsPostHandler::class,
            function() use ($services) {
                return new ProfilesFollowingsPostHandler(
                    $services->get(FollowUserByUsernameService::class),
                    $services->get(UsersRepositoryInterface::class)
                );
            }
        );

        $this->handlers->add(
            ProfilesFollowingsDeleteHandler::class,
            function() use ($services) {
                return new ProfilesFollowingsDeleteHandler();
            }
        );
    }

    /**
     * @param $className
     * @return HandlerInterface
     */
    public function create($className): HandlerInterface
    {
        return $this->handlers->get($className);
    }
}