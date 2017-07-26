<?php

use Repository\ArticleRepository;
use Repository\CategoryRepository;
use Repository\GiftRepository;
use Repository\PickuplocationRepository;
use Repository\ProductRepository;
use Repository\ShippingRepository;
use Repository\SubscriptionRepository;
use Repository\UserRepository;
use Service\SubscriptionManager;
use Service\UserManager;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\HttpFoundation\Request;  

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
    $twig->addGlobal('subscription_manager', $app['subscription.manager']);

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

$app->register(new SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'host' => 'smtp.google.com',
    'port' => 465,
    'username' => 'roullandmorgane@gmail.com',
    'password' => 'Morgane92350',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);

$app->register(new Request());

$app->register(new SwiftMailerTrait());

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

// On déclare le service ArticleRepository
$app['article.repository'] = function () use ($app){
    return new ArticleRepository($app['db']);
};

// On déclare le service CategoryRepository
$app['category.repository'] = function () use ($app){
    return new CategoryRepository($app['db']);
};

// On déclare le service GiftRepository
$app['gift.repository'] = function () use ($app){
    return new GiftRepository($app['db']);
};

/* Services autres */
$app['user.manager'] = function () use ($app){
    return new UserManager($app['session']);
};

$app['subscription.manager'] = function () use ($app){
    return new SubscriptionManager($app['session']);
};

return $app;
