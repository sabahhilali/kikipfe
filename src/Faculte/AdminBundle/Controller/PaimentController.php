<?php

namespace Faculte\AdminBundle\Controller;

use Faculte\AdminBundle\Entity\Paiment;
use Faculte\AdminBundle\Form\PaimentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaimentController extends Controller
{
    public function ajouterPaimentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paiment = new Paiment();
        $form = $this->createForm(PaimentType::class, $paiment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $paiment = $form->getData();
                $em->persist($paiment);
                $em->flush();

                return $this->redirect($this->generateUrl('faculte_admin_liste_paiment'));
            }
        }


        return $this->render('FaculteAdminBundle:Paiment:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listePaimentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paiment = $em->getRepository('FaculteAdminBundle:Paiment')->findAll();
        return $this->render('FaculteAdminBundle:Paiment:liste.html.twig', array('Paiment' => $paiment));

    }

    public function modifierPaimentAction($idPm, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paiment = $em->getRepository('FaculteAdminBundle:Paiment')->findOneById($idPm);
        $form = $this->createForm(PaimentType::class, $paiment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $paiment = $form->getData();
                $em->persist($paiment);
                $em->flush();

                return $this->redirect($this->generateUrl('faculte_admin_liste_paiment'));

            }
        }

        return $this->render('FaculteAdminBundle:Paiment:modifier.html.twig', array(
            'form' => $form->createView(), 'Paiment' => $paiment));

    }

    public function supprimerPaimentAction($idPm, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paiment = $em->getRepository('FaculteAdminBundle:Paiment')->findOneById($idPm);
        $em->remove($paiment);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_liste_paiment'));


    }

    public function suitPaimentAction($idPm)
    {
        $em = $this->getDoctrine()->getManager();
        $paiment = $em->getRepository('FaculteAdminBundle:Paiment')->findOneById($idPm);
        return $this->render('FaculteAdminBundle:Paiment:suit.html.twig', array('Paiment' => $paiment));

    }


    public function renderactivitesAction(Request $request)
    {

            $em = $this->getDoctrine()->getManager();
            $idactivite= $request->request->get('$idactivite');
            $activite = $em->getRepository('FaculteAdminBundle:Activite')->find($idactivite);
            $adherent = $em->getRepository('FaculteAdminBundle:Adherent')->findBy(array('activite'=>$activite));

            $idpaiment= $request->request->get('$idpaiment');
            $paiment = null;
            if(!empty($idpaiment)){
                $paiment = $em->getRepository('FaculteAdminBundle:Paiment')->find($idpaiment);
            }

            return $this->render('FaculteAdminBundle:Paiment:renderactivites.html.twig',array('adherents'=>$adherent,'paiment'=>$paiment));
        }



}