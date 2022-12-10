<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Coach;
use Faculte\AdminBundle\Form\CoachType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoachController extends Controller
{
    public function ajouterCoachAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $coach = $form->getData();
                $coach->uploadPathFile();
                $em->persist($coach);
                $em->flush();
                $coach->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_coach'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Coach:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeCoachAction()
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findAll();
        return $this->render('FaculteSuperAdminBundle:Coach:liste.html.twig', array('Coach' => $coach));

    }

    public function modifierCoachAction($idC, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneById($idC);
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $coach = $form->getData();
                $coach->uploadPathFile();
                $em->persist($coach);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_coach'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Coach:modifier.html.twig', array(
            'form' => $form->createView(), 'Coach' => $coach));

    }

    public function supprimerCoachAction($idC, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneById($idC);
        $em->remove($coach);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_coach'));
    }


    public function suitCoachAction($idC)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneById($idC);
        return $this->render('FaculteSuperAdminBundle:Coach:suit.html.twig', array('Coach' => $coach));

    }



}