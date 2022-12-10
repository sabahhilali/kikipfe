<?php

namespace Faculte\ClientBundle\Controller;

use Faculte\AdminBundle\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $client= $em->getRepository('FaculteAdminBundle:Client')->findBy(array('user' => $user));
        return $this->render('FaculteClientBundle:Default:index.html.twig', array('Client' => $client));
    }



    public function profilAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $client= $em->getRepository('FaculteAdminBundle:Client')->findBy(array('user' => $user));
        return $this->render('FaculteClientBundle:Client:profil.html.twig', array('Client' => $client));
    }
    public function modifierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $client= $em->getRepository('FaculteAdminBundle:Client')->findOneBy(array('user' => $user));
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $client = $form->getData();
                $em->persist($client);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_client_homepage'));
            }
        }

        return $this->render('FaculteClientBundle:Client:modifier.html.twig', array(
            'form' => $form->createView(),'client'=>$client));

    }
}
