<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) { // A modifier par Xavier
    return $app['twig']->render('index.html.twig', array());// A modifier par Xavier
})
->bind('homepage'); // A modifier par Xavier

/* FRONT */


/* USERS */
    
    // Inscription
        
    // Connexion
    
    // Deconnexion



/* ADMIN */

    // Gestion users
$app ->mount('/admin', $admin); 

$app['admin.user.controller'] = function () use ($app){
    return new AdminController;
};


$admin
    ->get('/users', 'admin.user.controller:listAction')  
    ->bind('admin_users')
;

$admin
    ->match('/users/edition/{id}', 'admin.user.controller:editAction')
    ->value('id', null)       
    ->assert('id', '\d+')
    ->bind('admin_user_edit')
        
    ->match('/users/suppression/{id}', 'admin.user.controller:deleteAction')   
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
