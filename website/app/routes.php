<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.html.twig');
});

$app->get('/search', function () use ($app) {
    return $app['twig']->render('search.html.twig');
});

// Error handler
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch($code) {
        case 404:
            return $app['twig']->render('404.html.twig');
    }
});
