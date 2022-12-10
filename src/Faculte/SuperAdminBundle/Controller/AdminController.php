<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Admin;
use Faculte\AdminBundle\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function ajouterAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $admin = $form->getData();
                $admin->uploadPathFile();
                $em->persist($admin);
                $em->flush();
                $admin->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_admin'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Admin:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('FaculteAdminBundle:Admin')->findAll();
        return $this->render('FaculteSuperAdminBundle:Admin:liste.html.twig', array('Admin' => $admin));

    }

    public function modifierAdminAction($idAm, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('FaculteAdminBundle:Admin')->findOneById($idAm);
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $admin = $form->getData();
                $admin->uploadPathFile();
                $em->persist($admin);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_admin'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Admin:modifier.html.twig', array(
            'form' => $form->createView(), 'Admin' => $admin));

    }

    public function supprimerAdminAction($idAm, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('FaculteAdminBundle:Admin')->findOneById($idAm);
        $em->remove($admin);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_admin'));


    }

    public function suitAdminAction($idAm)
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('FaculteAdminBundle:Admin')->findOneById($idAm);
        return $this->render('FaculteSuperAdminBundle:Admin:suit.html.twig', array('Admin' => $admin));

    }


}