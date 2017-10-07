<?php

// configure your app for the production environment

$app['twig.path'] = [
    __DIR__.'/../src/App/templates',
    __DIR__.'/../templates'
];
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
