<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Tarif;
use Faculte\AdminBundle\Form\TarifType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TarifController extends Controller
{
    public function ajouterTarifAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = new Tarif();
        $form = $this->createForm(TarifType::class, $tarif);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $tarif = $form->getData();
                $em->persist($tarif);
                $em->flush();

                return $this->redirect($this->generateUrl('faculte_super_admin_liste_tarif'));
            }
        }


        return $this->render('FaculteSuperAdminBundle:Tarif:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listeTarifAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->findAll();
        return $this->render('FaculteSuperAdminBundle:Tarif:liste.html.twig', array('Tarif' => $tarif));

    }

    public function modifierTarifAction($idT, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->findOneById($idT);
        $form = $this->createForm(TarifType::class, $tarif);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $tarif = $form->getData();
                $em->persist($tarif);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_super_admin_liste_tarif'));

            }
        }

        return $this->render('FaculteSuperAdminBundle:Tarif:modifier.html.twig', array(
            'form' => $form->createView(), 'Tarif' => $tarif));

    }

    public function supprimerTarifAction($idT, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->findOneById($idT);
        $em->remove($tarif);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_tarif'));
    }
    public function renderactivitesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idadherant = $request->request->get('idadherant');
        $idTarif = $request->request->get('idTarif');
        $adherant = $em->getRepository('FaculteAdminBundle:Adherant')->find($idadherant);
        $activite = $em->getRepository('FaculteAdminBundle:Niveau')->findBy(array('adherant'=>$adherant));
        $tarif = null;
        if($idTarif != null) {
            $tarif = $em->getRepository('FaculteAdminBundle:Tarif')->find($idTarif);
        }
        return $this->render('FaculteSuperAdminBundle:Tarif:renderactivites.html.twig',
            array('activite'=>$activite,'tarif'=>$tarif));
    }



}