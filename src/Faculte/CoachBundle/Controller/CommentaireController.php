<?php

namespace Faculte\CoachBundle\Controller;

use Faculte\AdminBundle\Entity\Commentaire;
use Faculte\AdminBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function commentaireAction(Request $request,$idCom)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $commentaire->setGalerie($idCom);
        $commentaire->setDateAjout(new \DateTime('now'));
        $form = $this->createForm( CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            if ($request->getMethod() == 'POST') {
                $commentaire = $form->getData();
                $em->persist($commentaire );
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_coach_homepage'));
            }
        }

        return $this->render('FaculteCoachBundle:Coach:commentaire.html.twig', array(
            'form' => $form->createView()));
    }

    public function listeAbonnementAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->findAll();
        return $this->render('FaculteAdminBundle:Abonnement:liste.html.twig', array('Abonnement' => $abonnement));

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

                return $this->redirect($this->generateUrl('faculte_admin_liste_abonnement'));

            }
        }

        return $this->render('FaculteAdminBundle:Abonnement:modifier.html.twig', array(
            'form' => $form->createView(), 'Abonnement' => $abonnement));

    }

    public function supprimerAbonnementAction($idAb, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->findOneById($idAb);
        $em->remove($abonnement);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_liste_abonnement'));


    }

    public function suitAbonnementAction($idAb)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository('FaculteAdminBundle:Abonnement')->findOneById($idAb);
        return $this->render('FaculteAdminBundle:Abonnement:suit.html.twig', array('Abonnement' => $abonnement));

    }


}