<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


// Apr�s avoir install� le composer Doctrine
// On instancie la base de donn�es
$app->register(
    new DoctrineServiceProvider(), 
    [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'fleursdici',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ]
);

// Services qui sont des repositories 

// On déclare le service UserRepository
$app['user.repository'] = function () use ($app) {
    return new UserRepository($app['db']);
};

return $app;
/*
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


// Apr�s avoir install� le composer Doctrine
$app->register(
    new DoctrineServiceProvider(), 
    [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'fleursdici',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ]
);

return $app;

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


// Apr�s avoir install� le composer Doctrine
// On instancie la base de donn�es
$app->register(
    new DoctrineServiceProvider(), 
    [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'fleursdici',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ]
);

// Services qui sont des repositories 

// On déclare le service UserRepository
$app['user.repository'] = function () use ($app) {
    return new UserRepository($app['db']);
};

return $app;
