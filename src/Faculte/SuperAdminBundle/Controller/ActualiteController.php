<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Actualite;
use Faculte\AdminBundle\Form\ActualiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActualiteController extends Controller
{
    public function ajouterActualiteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $actualite = $form->getData();
                $actualite->uploadPathFile();
                $em->persist($actualite);
                $em->flush();
                $actualite->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_actualite'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Actualite:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeActualiteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('FaculteAdminBundle:Actualite')->findAll();
        return $this->render('FaculteSuperAdminBundle:Actualite:liste.html.twig', array('Actualite' => $actualite));

    }

    public function modifierActualiteAction($idAct, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('FaculteAdminBundle:Actualite')->findOneById($idAct);
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $actualite = $form->getData();
                $actualite->uploadPathFile();
                $em->persist($actualite);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_actualite'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Actualite:modifier.html.twig', array(
            'form' => $form->createView(), 'Actualite' => $actualite));

    }



    public function suitActualiteAction($idAct)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('FaculteAdminBundle:Actualite')->findOneById($idAct);
        return $this->render('FaculteSuperAdminBundle:Actualite:suit.html.twig', array('Actualite' => $actualite));

    }



    public function supprimerActualiteAction($idAct, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('FaculteAdminBundle:Actualite')->findOneById($idAct);
        $em->remove($actualite);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_actualite'));

    }

}