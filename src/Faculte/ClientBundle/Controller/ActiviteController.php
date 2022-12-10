<?php

namespace Faculte\ClientBundle\Controller;

use Faculte\AdminBundle\Entity\Activite;
use Faculte\AdminBundle\Form\ActiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ActiviteController extends Controller
{

    public function afficherActiviteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository('FaculteAdminBundle:Activite')->findAll();
        return $this->render('FaculteClientBundle:Activite:activite.html.twig', array('Activite' => $activite));

    }

}