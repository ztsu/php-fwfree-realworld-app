<?php

namespace Realworld\App;

use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Realworld\App\Handler\HandlerFactory;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Service\User\AuthenticateUserByPasswordService;
use Zend\Diactoros\Response\SapiEmitter;

class ServiceProviderTest extends TestCase
{
    public function getTestCasesForServiceProviderTest(): array
    {
        return [
            [HandlerFactory::class],
            [App::class],
            [SapiApp::class],
            [SapiEmitter::class],
            [UsersRepositoryInterface::class],
            [AuthenticateUserByPasswordService::class],
        ];
    }

    /**
     * @dataProvider getTestCasesForServiceProviderTest
     */
    public function testContainerHasService(string $serviceName)
    {
        $container = (new Container())->addServiceProvider(new ServiceProvider());

        $this->assertTrue($container->has($serviceName));
    }
}