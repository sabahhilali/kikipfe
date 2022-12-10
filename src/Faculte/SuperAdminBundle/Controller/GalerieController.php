<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Galerie;
use Faculte\AdminBundle\Form\GalerieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalerieController extends Controller
{
    public function ajouterGalerieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galerie = new Galerie();
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $galerie = $form->getData();
                $galerie->uploadPathFile();
                $em->persist($galerie);
                $em->flush();
                $galerie->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_afficher_galerie'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Galerie:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }



    public function modifierGalerieAction($idG, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('FaculteAdminBundle:Galerie')->findOneById($idG);
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $galerie = $form->getData();
                $galerie->uploadPathFile();
                $em->persist($galerie);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_afficher_galerie'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Galerie:modifier.html.twig', array(
            'form' => $form->createView(), 'Galerie' => $galerie));

    }

    public function supprimerGalerieAction($idG, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('FaculteAdminBundle:Galerie')->findOneById($idG);
        $em->remove($galerie);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_afficher_galerie'));

    }

    public function afficherGalerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('FaculteAdminBundle:Galerie')->findAll();
        return $this->render('FaculteSuperAdminBundle:Galerie:afficher.html.twig', array('Galerie' => $galerie));

    }

}