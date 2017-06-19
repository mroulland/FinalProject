<?php

use Repository\UserRepository;
use Service\UserManager;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // pour avoir accès au service UserManager dans les templates
    // En paramètres : le nom de la globale, et ce qu'elle va contenir
    // Ca va correspondre à notre instance de la classe UserManager et donc toutes les méthodes qu'on a crée jusqu'ici
    $twig->addGlobal('user_manager', $app['user.manager']);

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

// Providers pour la validation de formulaire et l'ajout de Sessions
$app->register(new SessionServiceProvider());
$app->register(new ValidatorServiceProvider);

// Services qui sont des repositories

    // On déclare le service UserRepository
$app['user.repository'] = function () use ($app) {
    return new UserRepository($app['db']);
};

// On déclare le service ProductRepository
$app['product.repository'] = function () use ($app){
    return new ProdcuctRepository($app['db']);
};


/* Services autres */
$app['user.manager'] = function () use ($app){
    return new UserManager($app['session']);
};



return $app;
