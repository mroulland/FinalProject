<?php

use Controller\Admin\ProductController;
use Controller\Admin\UsersController;
use Controller\IndexController;
use Controller\ProfilController;
use Controller\UserController;
use Controller\EntrepriseController;
use Controller\SubscriptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/* FRONT */
// On déclare le controller index en service
$app['index.controller'] = function () use ($app) {
    return new IndexController($app);
};

$app
    ->get('/', 'index.controller:indexAction')
    ->bind('homepage')
;

/* USERS */
// Inscription
// On déclare le service UserController en action
$app['user.controller'] = function () use ($app) {
    return new UserController($app);
};

// Route pour l'inscription
$app
    ->match(
        'utilisateur/inscription',  // Chemin dans l'URL (à modifier ?)
        'user.controller:registerAction'
    )
    // Nom de la route
    ->bind('register')
;

$app->get('/layout', function () use ($app) {
    return $app['twig']->render('layout.html.twig', array());
})
->bind('layout')
;

$app->get('/test', function () use ($app) {
    return $app['twig']->render('register.html.twig', array());
})
->bind('test')
;

$app->get('/home', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('home')
;

/* FRONT */

// Route pour l'inscription
$app
    ->match(
        'utilisateur/inscription',
        'user.controller:registerAction'
    )
    ->bind('register')
;

// Route pour la connexion
$app
    ->match(
        'utilisateur/connexion',
        'user.controller:loginAction'
    )
    // Nom de la route
    ->bind('login')
;

// Deconnexion
$app
    ->get(
        'utilisateur/deconnexion',
        'user.controller:logoutAction'
    )
    ->bind('logout')
;

// Page profil
// Déclaration du service du controller de profil

$app['profil.controller'] = function () use ($app){
    return new ProfilController($app);
};

$app
    ->get(
        'utilisateur/profil',
        'profil.controller:profilAction'
    )
    ->bind('profil')
;

// Page abonnements
// Déclaration du service controller d'abonnement
$app['subscription.controller'] = function () use ($app){
    return new SubscriptionController($app);
};

// Route pour la page abonnement
$app
    ->match(
        'abonnement',
        'subscription.controller:subscriptionAction'
    )
    ->bind('abonnement')
;

// Route pour la page panier
$app
    ->get(
        'panier',
        'subscription.controller:panierList'
    )
    ->bind('panier')
;


// Déclaration du controler en service pour gérer les contacts
$app['entreprise.controller'] = function () use ($app){
    return new EntrepriseController($app);
};

// Route pour la page contact B2B
$app
    ->match(
        'contactentreprise',
        'entreprise.controller:sendMessage'
    )
    ->bind('contactentreprise')
;

/* ADMIN */


// Déclaration de service du controller user Admin
$app['admin.users.controller'] = function () use ($app){
    return new UsersController($app);
};

//créer un sous-ensemble de routes
$admin = $app['controllers_factory'];

$app ->mount('/admin', $admin);



$app->get('/admin', function() use ($app) {
    $product = $app['product.repository']->findAllProducts();
    $subscription = $app['subscription.repository']->findAll();
    $users = $app['user.repository']->findAll();
    return $app['twig']->render('admin/admin.html.twig', array(
        'product' => $product,
        'subscription' => $subscription,
        'users' => $users));
    })->bind('admin');


// Gestion users

$admin
    ->get('/users', 'admin.users.controller:listAction')
    ->bind('admin_users')
;

$admin
    ->match('/users/edition/{id}', 'admin.users.controller:editAction')
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('admin_user_edit')
;
$admin
    ->match('/users/suppression/{id}', 'admin.users.controller:deleteAction')
    ->bind('admin_user_delete')
;
    // Gestion produits

// déclaration du controller produit
$app['admin.product.controller'] = function () use ($app){
    return new ProductController($app);
};

$admin
    ->get('/product', 'admin.product.controller:listAction')
    ->bind('admin_product')
;

    // Gestion abonnements



$app->error(function (Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
