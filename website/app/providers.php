<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

ErrorHandler::register();
ExceptionHandler::register();

// Database
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app['dao.messages'] = function ($app) {
    return new YF\DAO\MessagesDAO($app['db']);
};
$app['dao.matches'] = function ($app) {
    return new YF\DAO\MatchesDAO($app['db']);
};

// Twig setup
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../views',
]);
$app['twig']->addGlobal('root', '/');
