<?php

namespace Faculte\AdherantBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProduitController extends Controller
{

    public function afficherProduitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('FaculteAdminBundle:Produit')->findAll();
        return $this->render('FaculteAdherantBundle:Produit:produit.html.twig', array('Produit' => $produit));

    }
}