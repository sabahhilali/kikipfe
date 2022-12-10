<?php

namespace Faculte\FrontBundle\Controller;

use Faculte\AdminBundle\Entity\Tarif;
use Faculte\AdminBundle\Form\TarifType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TarifController extends Controller
{

    public function afficherTarifAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->findAll();
        return $this->render('FaculteFrontBundle:Tarif:tarif.html.twig', array('Tarif' => $tarif));

    }

}