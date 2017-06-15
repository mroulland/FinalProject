<?php

namespace src\Controller;

use src\Entity\User;
use src\Form\Type\UserType;
use Silex\Application;
use Symfony\component\HttpFondation\Request;

class UserController
{
    public function profil (Request $request, Application $app)
    {

        $user = new User();
        $errors = [];
        $now = new \DateTime();
        $interval  = $now ->diff($user->getCreatedAt());
        $userSince = $interval->format('depuis  %d jours %H heures %I minutes');
    }

    $data = array(
        'membre' => $user,
        'membreDepuis' => $userSince,
    );

    return $app['twig']->render('profil.html.twig',$data);

    }
}