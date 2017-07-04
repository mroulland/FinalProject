<?php

use Controller\Admin\ProductController;
use Controller\Admin\UsersController;
use Controller\Admin\ShippingController;
use Controller\Admin\SubscriptionsController;
use Controller\Admin\PickuplocationController;
use Controller\Admin\ArticleController;
use Controller\Admin\CategoryController;
use Controller\StripeController;
use Controller\IndexController;
use Controller\UserController;
use Controller\ContactController;
use Controller\SubscriptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


                    /* FRONT */

    // On déclare le controller index en service
    $app['index.controller'] = function () use ($app) {
        return new IndexController($app);
    };

    $app
        ->match('/', 'index.controller:indexAction')
        ->bind('home')
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


    /*$app->get('/home', function () use ($app) {
        return $app['twig']->render('index.html.twig', array());
    })
    ->bind('home')
    ;*/


// USERS

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

    // Connexion
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
    $app
        ->get(
            'utilisateur/profil',
            'user.controller:profilAction'
        )
        ->bind('profil')
    ;
    
    // Modification du profil

    $app
        ->match(
            'utilisateur/profil/modifier/{id}',
            'user.controller:editAction'
        )
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('profil_edition')
    ;

    // Suspension de l'abonnement
    $app
        ->get(
            'utilisateur/profil/abonnement/{id}',
            'subscription.controller:toggleSubscription'
        )
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('abonnement_changement')
    ;

    // Reprise de l'abonnement
    $app
        ->get(
            'utilisateur/profil/reactive/{id}',
            'subscription.controller:reactivateSubscription'
        )
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('abonnement_reactive')
    ;

    // Modification de l'abonnement
    $app
        ->get(
            'utilisateur/profil/abo_modif/{id}',
            'subscription.controller:editSubscription'
        )
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('abonnement_edition')
    ;

    // Page 'Producteurs associés'

    $app->get('/producer',function() use ($app){
        return $app['twig']->render('producer.html.twig', array());
    })
       ->bind('producer')
    ;
 
    // Page 'Notre projet'
    $app->get('/ourproject',function() use ($app){
        return $app['twig']->render('ourproject.html.twig', array());
    })

       ->bind('ourproject')

    ;

    // Page 'Je m'abonne'

    // Déclaration du service controller d'abonnement

    $app['subscription.controller'] = function () use ($app){
        return new SubscriptionController($app);
    };
    
    
    
    // Route pour la page abonnement
    $app
        ->match(
            'abonnement/{productId}',
            'subscription.controller:subscriptionAction'
        )
        ->value('productId', null)
        ->assert('id', '\d+')
        ->bind('abonnement')
    ;

    // Page 'Panier'
    $app
        ->get(
            'panier/{productId}/{shippingId}',
            'subscription.controller:panierList'
        )
        ->bind('panier')
    ;

    $app
        ->match(
            'paiement/{productId}/{shippingId}',
            'subscription.controller:createPaiement'
        )
        ->bind('paiement_charge')
    ;

     $app
        ->match(
            'paiementabonnement/{productId}/{shippingId}',
            'subscription.controller:createNewSubscription'
        )
        ->bind('paiement_abonnement')
    ; 

    // Route Stripe
    $app['stripe.controller'] = function () use ($app){
        return new StripeController($app);
    };

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

    //Route blog user:
    $app->get('/blog',function() use ($app){
        return $app['twig']->render('blog.html.twig', array());
    })

       ->bind('blog')
    ;


            /* ADMIN (GESTION BACK-OFFICE) */

    //créer un sous-ensemble de routes
    $admin = $app['controllers_factory'];
    $app ->mount('/admin', $admin);


    $admin->before(function () use ($app) {
       if (!$app['user.manager']->isAdmin()){ // Si un admin n'est pas connecté 
           $app->abort(403, 'Accès refusé'); // HTTP 403 Forbidden
       }
    });

    // Fonction findAll()   
    $app->get('/admin', function() use ($app) {
        $product = $app['product.repository']->findAllProducts();
        $subscription = $app['subscription.repository']->findAllSubscriptions();
        $users = $app['user.repository']->findAll();
        return $app['twig']->render('admin/admin.html.twig', array(
            'product' => $product,
            'subscription' => $subscription,
            'users' => $users));
        })->bind('admin');



    // Route gestion category
    $app['admin.category.controller'] = function () use ($app) {
        return new CategoryController($app);
    };

    $admin
        ->get('/rubriques', 'admin.category.controller:listAction')  
        ->bind('admin_categories')
    ;

    $admin
        ->match('/rubriques/edition/{id}', 'admin.category.controller:editAction') 
        ->value('id', null)
        ->bind('admin_category_edit')
    ;

    $admin
        ->match('/rubriques/suppression/{id}', 'admin.category.controller:deleteAction')
        ->bind('admin_category_delete')
    ;

    // Route gestion article
    $app['admin.article.controller'] = function () use ($app) {
    return new ArticleController($app);
    };

    $admin
    ->get('/articles', 'admin.article.controller:listAction')  
    ->bind('admin_articles')
    ;

    $admin
    ->match('/articles/edition/{id}', 'admin.article.controller:editAction')
    ->value('id', null)
        // si la valeur est précisée, ça doit être un nombre ('\d+' est une expression régulière qui signifie nombre
    ->assert('id', '\d+')
    ->bind('admin_article_edit')
    ;

    $admin
    ->match('/articles/suppression/{id}', 'admin.article.controller:deleteAction')
    ->bind('admin_article_delete')
    ;

// GESTION DES UTILISATEURS    
    // Déclaration de service du controller user Admin
    $app['admin.users.controller'] = function () use ($app){
        return new UsersController($app);
    };

        
    // Déclaration du controller utilisateurs
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


//GESTION DES PRODUITS

    // Déclaration du controller produit
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

    // Editer un produit
    $admin
        ->match('/product/edition/{id}', 'admin.product.controller:editAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_product_edit')
    ;

    // Supprimer un produit
    $admin
        ->match('/product/suppression/{id}', 'admin.product.controller:deleteAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_product_delete')
    ;



// GESTION DES ABONNEMENTS

    // Déclaration du controller abonnement
    $app['admin.subscription.controller'] = function () use ($app){
        return new SubscriptionsController($app);
    };

    $admin
        ->get('/subscription', 'admin.subscription.controller:listAction')
        ->bind('admin_subscription')
    ;

    // Ajouter un abonnement
    $admin
        ->match('subscription/ajout', 'admin.subscription.controller:registerAction')
        ->bind('admin_subscription_ajout')
    ;
    
    // Editer un abonnement
    $admin
        ->match('/subscription/edition/{id}', 'admin.subscription.controller:editAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_subscription_edit')
    ;

    // Supprimer un abonnement
    $admin
        ->match('/subscription/suppression/{id}', 'admin.subscription.controller:deleteAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_subscription_delete')
    ;


// GESTIONS DES LIVRAISONS

    // Déclaration du controller shipping 
    $app['admin.shipping.controller'] = function () use ($app){
        return new ShippingController($app);
    };
    
    // Liste des livraison
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
    
    // Supprimer une livraison
    $admin
        ->match('/shipping/suppression/{id}', 'admin.shipping.controller:deleteAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_shipping_delete')
    ;

// GESTION DES POINTS RELAIS
    
    // Déclaration du controller pickuplocation
    $app['admin.pickuplocation.controller'] = function () use ($app){
        return new PickuplocationController($app);
    };

    // Liste des points relais
    $admin
        ->get('/pickuplocation', 'admin.pickuplocation.controller:listAction')
        ->bind('admin_pickuplocation')
    ;

    // Ajouter un point relais
    $admin
        ->match('pickuplocation/ajout', 'admin.pickuplocation.controller:registerAction')
        ->bind('admin_pickuplocation_ajout')
    ;

    // Editer un point relais
    $admin
        ->match('/pickuplocation/edition/{id}', 'admin.pickuplocation.controller:editAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_pickuplocation_edit')
    ;

    // Supprimer un point relais
    $admin
        ->match('/pickuplocation/suppression/{id}', 'admin.pickuplocation.controller:deleteAction')
        ->value('id', null)
        ->assert('id', '\d+')
        ->bind('admin_pickuplocation_delete')
    ;

 // GESTION DES ERREURS   
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



