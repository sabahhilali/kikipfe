<?php

namespace Faculte\ClientBundle\Controller;

use Faculte\AdminBundle\Entity\Galerie;
use Faculte\AdminBundle\Form\GalerieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class GalerieController extends Controller
{

    public function afficherGalerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('FaculteAdminBundle:Galerie')->findAll();
        return $this->render('FaculteClientBundle:Galerie:galerie.html.twig', array('Galerie' => $galerie));

    }

}