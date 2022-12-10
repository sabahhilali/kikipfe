<?php

namespace Faculte\AdherantBundle\Controller;

use Faculte\AdminBundle\Entity\Exercice;
use Faculte\AdminBundle\Form\ExerciceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ExerciceController extends Controller
{

    public function afficherExerciceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findAll();
        return $this->render('FaculteAdherantBundle:Exercice:exercice.html.twig', array('Exercice' => $exercice));

    }

    public function suitExerciceAction($idE)
    {
        $em = $this->getDoctrine()->getManager();
        $exercice = $em->getRepository('FaculteAdminBundle:Exercice')->findOneById($idE);
        return $this->render('FaculteAdherantBundle:Exercice:suit.html.twig', array('Exercice' => $exercice));

    }
}