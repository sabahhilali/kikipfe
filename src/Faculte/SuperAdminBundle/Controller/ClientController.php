<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Client;
use Faculte\AdminBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    public function ajouterClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $client = $form->getData();
                $client->uploadPathFile();
                $em->persist($client);
                $em->flush();
                $client->movePathFile();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_client'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Client:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeClientAction()
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('FaculteAdminBundle:Client')->findAll();
        return $this->render('FaculteSuperAdminBundle:Client:liste.html.twig', array('Client' => $client));

    }

    public function modifierClientAction($idClt, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('FaculteAdminBundle:Client')->findOneById($idClt);
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $client = $form->getData();
                $client->uploadPathFile();
                $em->persist($client);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_client'));

            }
        }
        return $this->render('FaculteSuperAdminBundle:Client:modifier.html.twig', array(
            'form' => $form->createView(), 'Client' => $client));

    }

    public function supprimerClientAction($idClt, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('FaculteAdminBundle:Client')->findOneById($idClt);
        $em->remove($client);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_client'));


    }

    public function suitClientAction($idClt)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('FaculteAdminBundle:Client')->findOneById($idClt);
        return $this->render('FaculteSuperAdminBundle:Client:suit.html.twig', array('Client' => $client));

    }


}