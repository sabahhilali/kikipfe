<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Activite;
use Faculte\AdminBundle\Form\ActiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActiviteController extends Controller
{
    public function ajouterActiviteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $activite = $form->getData();
                $activite->uploadPathFile();
                $em->persist($activite);
                $em->flush();
                $activite->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_activite'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Activite:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeActiviteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository('FaculteAdminBundle:Activite')->findAll();
        return $this->render('FaculteSuperAdminBundle:Activite:liste.html.twig', array('Activite' => $activite));

    }

    public function modifierActiviteAction($idA, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository('FaculteAdminBundle:Activite')->findOneById($idA);
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $activite = $form->getData();
                $activite->uploadPathFile();
                $em->persist($activite);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_activite'));

            }
        }

        return $this->render('FaculteAdminBundle:Activite:modifier.html.twig', array(
            'form' => $form->createView(), 'Activite' => $activite));

    }

    public function suitActiviteAction($idA)
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository('FaculteAdminBundle:Activite')->findOneById($idA);
        return $this->render('FaculteSuperAdminBundle:Activite:suit.html.twig', array('Activite' => $activite));

    }

    public function supprimerActiviteAction($idA, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $activite = $em->getRepository('FaculteAdminBundle:Activite')->findOneById($idA);
        $em->remove($activite);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_activite'));


    }

}