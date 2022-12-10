<?php

namespace Faculte\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $Adherents = $em->getRepository('FaculteAdminBundle:Adherent')->findAll();
        $Coachs = $em->getRepository('FaculteAdminBundle:Coach')->findAll();
        $Clients = $em->getRepository('FaculteAdminBundle:Client')->findAll();

        $Activites = $em->getRepository('FaculteAdminBundle:Activite')->findAll();
        $Exercices = $em->getRepository('FaculteAdminBundle:Exercice')->findAll();

        return $this->render('FaculteAdminBundle:Default:index.html.twig',array('Adherents'=>$Adherents,'Coachs'=>$Coachs,'Clients'=>$Clients,'Activites'=>$Activites ,'Exercices'=>$Exercices ));
    }


}
