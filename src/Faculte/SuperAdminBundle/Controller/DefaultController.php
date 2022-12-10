<?php

namespace Faculte\SuperAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Adherents = $em->getRepository('FaculteAdminBundle:Adherent')->findAll();
        return $this->render('FaculteSuperAdminBundle:Default:index.html.twig',array('Adherents'=>$Adherents));


        $em1 = $this->getDoctrine()->getManager();
        $Activites = $em1->getRepository('FaculteAdminBundle:Activite')->findAll();
        return $this->render('FaculteSuperAdminBundle:Default:index.html.twig',array('Activites'=>$Activites));


        $em2 = $this->getDoctrine()->getManager();
        $Admins = $em2->getRepository('FaculteAdminBundle:Admin')->findAll();
        return $this->render('FaculteSuperAdminBundle:Default:index.html.twig',array('Admins'=>$Admins));


        $em3 = $this->getDoctrine()->getManager();
        $Produits = $em3->getRepository('FaculteAdminBundle:Produit')->findAll();
        return $this->render('FaculteSuperAdminBundle:Default:index.html.twig',array('Produits'=>$Produits));




    }
}
