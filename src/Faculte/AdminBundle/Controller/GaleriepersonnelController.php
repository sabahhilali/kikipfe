<?php

namespace Faculte\AdminBundle\Controller;

use Faculte\AdminBundle\Entity\Galeriepersonnel;
use Faculte\AdminBundle\Form\GaleriepersonnelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GaleriepersonnelController extends Controller
{
    public function ajouterGaleriepersonnelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galeriepersonnel = new Galeriepersonnel();
        $form = $this->createForm(GaleriepersonnelType::class, $galeriepersonnel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $galeriepersonnel = $form->getData();
                $galeriepersonnel->uploadPathFile();
                $em->persist($galeriepersonnel);
                $em->flush();
                $galeriepersonnel->movePathFile();

                return $this->redirect($this->generateUrl('faculte_admin_afficher_galeriepersonnel'));
            }
        }


        return $this->render('FaculteAdminBundle:Galeriepersonnel:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function modifierGaleriepersonnelAction($idGp, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galeriepersonnel = $em->getRepository('FaculteAdminBundle:Galeriepersonnel')->findOneById($idGp);
        $form = $this->createForm(GaleriepersonnelType::class, $galeriepersonnel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $galeriepersonnel = $form->getData();
                $galeriepersonnel->uploadPathFile();
                $em->persist($galeriepersonnel);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_admin_afficher_galeriepersonnel'));

            }
        }

        return $this->render('FaculteAdminBundle:Galeriepersonnel:modifier.html.twig', array(
            'form' => $form->createView(), 'Galeriepersonnel' => $galeriepersonnel));

    }

    public function supprimerGaleriepersonnelAction($idGp, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $galeriepersonnel = $em->getRepository('FaculteAdminBundle:Galeriepersonnel')->findOneById($idGp);
        $em->remove($galeriepersonnel);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_afficher_galeriepersonnel'));

    }


    public function afficherGaleriepersonnelAction()
    {
        $em = $this->getDoctrine()->getManager();
        $galeriepersonnel = $em->getRepository('FaculteAdminBundle:Galeriepersonnel')->findAll();
        return $this->render('FaculteAdminBundle:Galeriepersonnel:afficher.html.twig', array('Galeriepersonnel' => $galeriepersonnel));

    }
}