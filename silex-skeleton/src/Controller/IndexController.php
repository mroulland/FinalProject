<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of IndexController
 *
 * @author Etudiant
 */
class IndexController extends ControllerAbstract
{
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }
}
