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
})->bind('matches');

$app->get('/matches/{date}', function ($date) use ($app) {
    $data = $app['dao.messages']->find($date);

    return $app['twig']->render('sentiments.html.twig', $data);
})->bind('sentiments');

// API
$app->get('/api/matches/{date}', function ($date) use ($app) {
    $data = $app['dao.messages']->getSentiment($date);

    return $app->json([
        'sentiment' => $data,
    ]);
});

$app->get('/api/matches/{date}/{id}', function ($date, $id) use ($app) {
    $data = $app['dao.messages']->getSentimentById($date, $id);

    return $app->json([
        'id' => $id,
        'sentiment' => $data,
    ]);
});

// Error handler
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 404:
            return $app['twig']->render('404.html.twig');
    }
});
