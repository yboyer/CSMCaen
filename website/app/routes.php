<?php

use Symfony\Component\HttpFoundation\Request;

// Routes
$app->get('/', function () use ($app) {
    return $app->redirect('/matches');
})->bind('home');

$app->get('/matches', function () use ($app) {
    $matches = $app['dao.matches']->findAll();

    return $app['twig']->render('matches.html.twig', [
        'matches' => $matches,
    ]);
});

// Error handler
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 404:
            return $app['twig']->render('404.html.twig');
    }
});
