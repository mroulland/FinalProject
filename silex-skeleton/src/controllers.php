<?php

use Controller\Admin\ProductController;
use Controller\Admin\UsersController;
use Controller\IndexController;
use Controller\ProfilController;
use Controller\UserController;
use Controller\ContactController;
use Controller\SubscriptionController;
use Controller\ShippingController;
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

// Route affichage du profil
$app
    ->get(
        'utilisateur/profil',
        'profil.controller:profilAction'
    )
    ->bind('profil')
;
// Route modification du profil
$app
    ->match(
        'utilisateur/profil/modifier/{id}',
        'user.controller:editAction'
    )
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('profil_edition')
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

// Page Panier
$app
    ->get(
        'panier/{productId}',
        'subscription.controller:panierList'
    )
    ->bind('panier')
;

// ContactRoute pour la page contact(entreprise + particulier)
$app['contact.controller'] = function () use ($app){
    return new ContactController($app);
};

$app
    ->match(
        'contact',
        'contact.controller:sendMessage'
    )
    ->bind('contact')
;

//Route pour envoie du form contact sur la boite mail de la boite.
$app
    ->post(
        'contact/mail',
        'contact.controller:sendMessage'
    )
    ->bind('contact_mail')
;

/* ADMIN */


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

// Déclaration de service du controller user Admin
$app['admin.users.controller'] = function () use ($app){
    return new UsersController($app);
};


// Gestion users

$admin
    ->get('/users', 'admin.users.controller:listAction')
    ->bind('admin_users')
;

// Ajouter un utilisateur
$admin
    ->match('users/ajout', 'admin.users.controller:registerAction')
    ->bind('admin_user_ajout')
;

// Modifier un utilisateur
$admin
    ->match('/users/edition/{id}', 'admin.users.controller:editAction')
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('admin_user_edit')
;

// Supprimer un utilisateur
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
    ->get('/products', 'admin.product.controller:listAction')
    ->bind('admin_products')
;

// Ajouter un produit
$admin
    ->match('product/ajout', 'admin.product.controller:registerAction')
    ->bind('admin_product_ajout')
;

$admin
    ->match('/product/edition/{id}', 'admin.product.controller:editAction')
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('admin_product_edit')
;

$admin
    ->match('/product/suppression/{id}', 'admin.product.controller:deleteAction')
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('admin_product_delete')
;

    // Gestion abonnements


    // Gestion Livraisons
$admin
    ->get('/shipping', 'admin.shipping.controller:listAction')
    ->bind('admin_shipping')
;

// Modifier des infos de livraison
$admin
    ->match('/shipping/edition/{id}', 'admin.shipping.controller:editAction')
    ->value('id', null)
    ->assert('id', '\d+')
    ->bind('admin_shipping_edit')
;


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

