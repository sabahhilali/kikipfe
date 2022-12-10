<?php

namespace Faculte\CoachBundle\Controller;

use Faculte\AdminBundle\Form\CoachType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoachController extends Controller
{


    public function profilAction()

    {   $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneBy(array('user' => $user));
        return $this->render('FaculteCoachBundle:Coach:profil.html.twig', array('Coach' => $coach));
    }

    public function modifierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $coach= $em->getRepository('FaculteAdminBundle:Coach')->findOneBy(array('user' => $user));
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $coach = $form->getData();
                $coach->uploadPathFile();
                $em->persist($coach);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_coach_homepage'));

            }
        }
        return $this->render('FaculteCoachBundle:Coach:modifier.html.twig', array(
            'form' => $form->createView(), 'coach' => $coach));

    }





}