<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->get('/test', function () use ($app) {
    return $app['twig']->render('register.html.twig', array());
})
->bind('test')
;


/* FRONT */


/* MEMBRES */



/* ADMIN */

    // Gestion membres
    /*
$app ->mount('/admin', $admin); 

$app['admin.membre.controller'] = function () use ($app){
    return new AdminController;
};


$admin
    ->get('/membres', 'admin.membre.controller:listAction')  
    ->bind('admin_membres')
;

$admin
    ->match('/membres/edition/{id}', 'admin.membre.controller:editAction')
    ->value('id', null)       
    ->assert('id', '\d+')
    ->bind('admin_membre_edit')
        
    ->match('/membres/suppression/{id}', 'admin.membre.controller:deleteAction')   
    ->bind('admin_membre_delete')
;
    // Gestion produits

    // Gestion abonnements
*/





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
