<?php

namespace Realworld\App;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;
use Ztsu\Reacon\Reacon;

/**
 * SAPI App
 *
 * Runs app, gets a response and emits it over PHP SAPI environment
 */
class SapiApp
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var SapiEmitter
     */
    private $emitter;

    /**
     * @param App $app
     * @param SapiEmitter $emitter
     */
    public function __construct(App $app, SapiEmitter $emitter)
    {
        $this->app = $app;
        $this->emitter = $emitter;
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function run(ServerRequestInterface $request)
    {
        $this->emitter->emit($this->app->run($request));
    }
}