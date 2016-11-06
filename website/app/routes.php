
<?php

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.html.twig');
});

$app->get('/search', function () use ($app) {
    return $app['twig']->render('search.html.twig');
});
