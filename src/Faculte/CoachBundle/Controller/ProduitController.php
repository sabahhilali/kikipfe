<?php

namespace Faculte\CoachBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProduitController extends Controller
{

    public function afficherProduitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('FaculteAdminBundle:Produit')->findAll();
        return $this->render('FaculteCoachBundle:Produit:produit.html.twig', array('Produit' => $produit));

    }
}