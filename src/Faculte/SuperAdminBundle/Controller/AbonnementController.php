<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Abonnement;
use Faculte\AdminBundle\Form\AbonnementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AbonnementController extends Controller
{
    public function ajouterAbonnementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = new Abonnement();
        $abonnement->setDateCreation(new \DateTime('now'));
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $abonnement = $form->getData();
                $em->persist($abonnement);
                $em->flush();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_abonnement'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Abonnement:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeAbonnementAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteSuperAdminBundle:Abonnement')->findAll();
        return $this->render('FaculteSuperAdminBundle:Abonnement:liste.html.twig', array('Abonnement' => $abonnement));

    }

    public function modifierAbonnementAction($idAb, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->findOneById($idAb);
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $abonnement = $form->getData();
                $em->persist($abonnement);
                $em->flush();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_abonnement'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Abonnement:modifier.html.twig', array(
            'form' => $form->createView(), 'Abonnement' => $abonnement));

    }

    public function supprimerAbonnementAction($idAb, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->findOneById($idAb);
        $em->remove($abonnement);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_abonnement'));


    }

    public function suitAbonnementAction($idAb)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteSuperAdminBundle:Abonnement')->findOneById($idAb);
        return $this->render('FaculteSuperAdminBundle:Abonnement:suit.html.twig', array('Abonnement' => $abonnement));

    }


     public function renderactivitesAction(Request $request)
     {

             $em = $this->getDoctrine()->getManager();
             $idactivite= $request->request->get('$idactivite');
             $activite = $em->getRepository('FaculteAdminBundle:Activite')->find($idactivite);
             $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->findBy(array('activite'=>$activite));

             $idabonnement= $request->request->get('idabonnement');
             $abonnement = null;
             if(!empty($idabonnement)){
                 $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->find($idabonnement);
             }

             return $this->render('FaculteSuperAdminBundle:Abonnement:renderactivites.html.twig',array('tarif'=>$tarif,'abonnement'=>$abonnement));
         }


}