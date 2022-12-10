<?php

namespace Faculte\AdherantBundle\Controller;

use Faculte\AdminBundle\Entity\Adherent;
use Faculte\AdminBundle\Form\AdherentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdherentController extends Controller
{
    public function profilAction()

    {   $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $adherent = $em->getRepository('FaculteAdminBundle:Adherent')->findOneBy(array('user' => $user));
        return $this->render('FaculteAdherantBundle:Adherent:profil.html.twig', array('Adherent' => $adherent));
    }

    public function modifierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $adherent= $em->getRepository('FaculteAdminBundle:Adherent')->findOneBy(array('user' => $user));
        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $adherent = $form->getData();
                $adherent->uploadPathFile();
                $em->persist($adherent);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_adherant_homepage'));

            }
        }
        return $this->render('FaculteAdherantBundle:Adherent:modifier.html.twig', array(
            'form' => $form->createView(), 'Adherent' => $adherent));

    }

}