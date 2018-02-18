<?php

namespace Realworld\App;

use Firebase\JWT\JWT;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Realworld\App\Authentication\TokenService;
use Realworld\App\Handler\HandlerFactory;
use Realworld\App\Repository\FollowingsRepository;
use Realworld\App\Repository\UsersRepository;
use Realworld\Domain\Repository\FollowingsRepositoryInterface;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Service\User\AuthenticateUserByPasswordService;
use Realworld\Domain\Service\User\CheckUserFollowedByUserService;
use Realworld\Domain\Service\User\CreateUserService;
use Realworld\Domain\Service\User\FollowUserByUsernameService;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * Service provider for League container
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    private $services;

    public function __construct(array $config = [])
    {
        $this->services = [
            HandlerFactory::class => function() {
                return new HandlerFactory($this->getContainer());
            },

            App::class => function () {
                return new App($this->getContainer());
            },

            SapiApp::class => function() {
                return new SapiApp(
                    $this->getContainer()->get(App::class),
                    $this->getContainer()->get(SapiEmitter::class)
                );
            },

            SapiEmitter::class => function () {
                return new SapiEmitter();
            },

            "mysql" => function() {
                return new \PDO("mysql:dbname=realworld;host=127.0.0.1;port=3306", "root", "");
            },

            TokenService::class => function() use ($config) {
                return new TokenService(new JWT, $config["jwt"]["privateKey"]);
            },

            UsersRepositoryInterface::class => function() {
                return new UsersRepository($this->getContainer()->get("mysql"));
            },

            FollowingsRepositoryInterface::class => function() {
                return new FollowingsRepository($this->getContainer()->get("mysql"));
            },

            CreateUserService::class => function() {
                return new CreateUserService(
                    $this->getContainer()->get(UsersRepositoryInterface::class)
                );
            },

            AuthenticateUserByPasswordService::class => function() {
                return new AuthenticateUserByPasswordService(
                    $this->getContainer()->get(UsersRepositoryInterface::class)
                );
            },

            CheckUserFollowedByUserService::class => function() {
                return new CheckUserFollowedByUserService(
                    $this->getContainer()->get(FollowingsRepositoryInterface::class)
                );
            },

            FollowUserByUsernameService::class => function() {
                return new FollowUserByUsernameService(
                    $this->getContainer()->get(UsersRepositoryInterface::class),
                    $this->getContainer()->get(FollowingsRepositoryInterface::class)
                );
            }
        ];

        $this->provides = array_keys($this->services);
    }

    public function register()
    {
        foreach ($this->services as $alias => $service) {
            $this->getContainer()->add($alias, $service);
        }
    }
}
