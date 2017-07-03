<?php

use Repository\ProductRepository;
use Repository\UserRepository;
use Repository\CategoryRepository;
use Repository\ArticleRepository;
use Repository\SubscriptionRepository;
use Repository\ShippingRepository;
use Repository\PickuplocationRepository;
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


$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1',
    'assets.version_format' => '%s?version=%s',
    'assets.named_packages' => array(
        'css' => array('version' => 'css2', 'base_path' => '/whatever-makes-sense'),
        'images' => array('base_urls' => array('https://img.example.com')),
    ),
));


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

//Ajout du swiftmailer pour envoyer mail contact vers boite mail des fleurs d'ici
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

$app['swiftmailer.options'] = array(
	'host' => 'localhost',
	'port' => 25,
	'username' => 'fc.cabrones@gmail.com',
	'password' => 'cabrones75',
	'encryption' => 'null',
	'auth_mode' => 'null'
);

// Services qui sont des repositories

    // On déclare le service UserRepository
$app['user.repository'] = function () use ($app) {
    return new UserRepository($app['db']);
};

// On déclare le service ProductRepository
$app['product.repository'] = function () use ($app){
    return new ProductRepository($app['db']);
};

// On déclare le service SubscriptionRepository
$app['subscription.repository'] = function () use ($app){
    return new SubscriptionRepository($app['db']);
};

// On déclare le service ShippingRepository
$app['shipping.repository'] = function () use ($app){
    return new ShippingRepository($app['db']);
};

// On déclare le service ShippingRepository
$app['pickuplocation.repository'] = function () use ($app){
    return new PickuplocationRepository($app['db']);
};

/* Services autres */
$app['user.manager'] = function () use ($app){
    return new UserManager($app['session']);
};

// Sercie category.repo pour blog
$app['category.repository'] = function () use ($app){
    return new CategoryRepository($app['db']);
};

// Sercie article.repo pour blog
$app['article.repository'] = function () use ($app){
    return new ArticleRepository($app['db']);
};



return $app;
