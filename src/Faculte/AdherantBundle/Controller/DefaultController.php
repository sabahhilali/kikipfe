<?php

namespace Faculte\AdherantBundle\Controller;


use Faculte\AdminBundle\Form\AdherentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FaculteAdherantBundle:Default:index.html.twig');
    }

}
