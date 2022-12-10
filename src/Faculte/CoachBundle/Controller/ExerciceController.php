<?php

namespace Faculte\CoachBundle\Controller;

use Faculte\AdminBundle\Entity\Exercice;
use Faculte\AdminBundle\Form\ExerciceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExerciceController extends Controller
{
    public function ajouterExerciceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $exercice = $form->getData();
                $exercice->uploadPathFile();
                $em->persist($exercice);
                $em->flush();
                $exercice->movePathFile();

                return $this->redirect($this->generateUrl('faculte_coach_liste_exercice'));
            }
        }


        return $this->render('FaculteCoachBundle:Exercice:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeExerciceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findAll();
        return $this->render('FaculteCoachBundle:Exercice:liste.html.twig', array('Exercice' => $exercice));

    }

    public function modifierExerciceAction($idE, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findOneById($idE);
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $exercice = $form->getData();
                $exercice->uploadPathFile();
                $em->persist($exercice);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_coach_liste_exercice'));

            }
        }

        return $this->render('FaculteCoachBundle:Exercice:modifier.html.twig', array(
            'form' => $form->createView(), 'Exercice' => $exercice));

    }

    public function supprimerExerciceAction($idE, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findOneById($idE);
        $em->remove($exercice);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_coach_liste_exercice'));

    }

    public function suitExerciceAction($idE)
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findOneById($idE);
        return $this->render('FaculteCoachBundle:Exercice:suit.html.twig', array('Exercice' => $exercice));

    }

}