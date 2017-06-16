<?php

use Controller\Admin\UsersController;
use Controller\IndexController;
use Controller\UserController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/* FRONT */
// On déclare le controller index en service
$app['index.controller'] = function () use ($app) {
    return new IndexController($app);
};



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


/* ADMIN */
// Déclaration de service du controller Admin
$app['admin.user.controller'] = function () use ($app){
    return new UsersController($app);
};

//créer un sous-ensemble de routes
$admin = $app['controllers_factory'];


    // Gestion users

$app ->mount('/admin', $admin); 


$admin
    ->get('/users', 'admin.users.controller:listAction')  
    ->bind('admin_users')
;

$admin
    ->match('/users/edition/{id}', 'admin.users.controller:editAction')
    ->value('id', null)       
    ->assert('id', '\d+')
    ->bind('admin_user_edit')
        
    ->match('/users/suppression/{id}', 'admin.users.controller:deleteAction')   
    ->bind('admin_user_delete')
;
    // Gestion produits

    // Gestion abonnements



$app->error(function (\Exception $e, Request $request, $code) use ($app) {
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
