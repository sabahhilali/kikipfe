<?php

namespace Faculte\AdminBundle\Controller;

use Faculte\AdminBundle\Entity\Produit;
use Faculte\AdminBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{

    public function ajouterProduitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $produit = $form->getData();
                $produit->uploadPathFile();
                $em->persist($produit);
                $em->flush();
                $produit->movePathFile();

                return $this->redirect($this->generateUrl('faculte_admin_liste_activite'));
            }
        }


        return $this->render('FaculteAdminBundle:Produit:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function modifierProduitAction($idP, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('FaculteAdminBundle:Produit')->findOneById($idP);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $produit = $form->getData();
                $produit->uploadPathFile();
                $em->persist($produit);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_admin_liste_activite'));

            }
        }

        return $this->render('FaculteAdminBundle:Produit:modifier.html.twig', array(
            'form' => $form->createView(), 'Produit' => $produit));

    }

    public function supprimerProduitAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('FaculteAdminBundle:Produit')->findOneById($idP);
        $em->remove($produit);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_liste_activite'));


    }

    public function afficherProduitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('FaculteAdminBundle:Produit')->findAll();
        return $this->render('FaculteAdminBundle:Produit:afficher.html.twig', array('Produit' => $produit));

    }
}