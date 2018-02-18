<?php

declare(strict_types=1);

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", "0");

require __DIR__ . "/../vendor/autoload.php";

$config = require(__DIR__ . "/../config/app.php");

(new \League\Container\Container())
    ->addServiceProvider(new \Realworld\App\ServiceProvider($config))
    ->get(\Realworld\App\SapiApp::class)
    ->run(\Zend\Diactoros\ServerRequestFactory::fromGlobals());
