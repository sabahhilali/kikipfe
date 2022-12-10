<?php

namespace Faculte\SuperAdminBundle\Controller;

use Faculte\AdminBundle\Entity\Adherent;
use Faculte\AdminBundle\Form\AdherentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdherentController extends Controller
{
    public function ajouterAdherentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Adherent = new Adherent();
        $form = $this->createForm( AdherentType::class, $Adherent);
        $form->handleRequest($request);
        $user = new User();
        $form2 = $this->createForm( UserType::class, $user);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->getMethod() == 'POST') {

                $Adherent = $form->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form2->getData();
                //ajouter role enseignant
                $role = array('ROLE_ADHERANT');
                $user->setRoles($role);
                $user->setEnabled(true);
                //persist(mis en memoire l'objet $user
                $em->persist($user);
                //affecter l'objet user à l'enseignant
                $Adherent->setUser($user);
                //persist(mis en memoire l'objet $enseignant
                $Adherent->uploadPathFile();
                $em->persist($Adherent);

                try {

                    $em->flush();
                    $Adherent->movePathFile();

                } catch (\Exception $e) {
                    $users=$em->getRepository('FaculteAdminBundle:User')->findAll();
                    $errorUsername="";
                    $errorEmail="";
                    //chercher l'existance du username dans UserFos
                    foreach($users as $userfos){
                        if( $userfos->getUsername() == $user->getUsername()){
                            $errorUsername = "Le nom d'utilisateur est déjà utilisé" ;
                        }elseif($userfos->getEmail() == $user->getEmail()){
                            $errorEmail = "L'adresse e-mail est déjà utilisée" ;
                        }
                    }
                    return $this->render('FaculteSuperAdminBundle:Adherent:ajouter.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'errorUsername'=>$errorUsername,'errorEmail'=>$errorEmail
                    ));
                }


                return $this->redirect($this->generateUrl('faculte_super_admin_liste_adherent'));
            }
        }

        return $this->render('FaculteSuperAdminBundle:Adherent:ajouter.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView()
        ));
    }


    public function listeAdherentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->getRepository('FaculteAdminBundle:Adherent')->findAll();
        return $this->render('FaculteSuperAdminBundle:Adherent:liste.html.twig', array('Adherent' => $adherent));

    }

    public function modifierAdherentAction($idAd,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Adherent=$em->getRepository('FaculteAdminBundle:Adherent')->findOneById($id);
        $user=$Adherent->getUser();
        $form = $this->createForm(AdherentType::class, $Adherent);
        $form2 = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->isMethod('POST')) {
                $Adherent = $form->getData();
                $user = $form2->getData();
                $em->persist($user);
                $Adherent->setUser($user);
                $em->persist($Adherent);
                try {

                    $em->flush();

                } catch (\Exception $e) {
                    $users=$em->getRepository('FaculteAdminBundle:User')->findAll();
                    $errorUsername="";
                    $errorEmail="";
                    //chercher l'existance du username dans UserFos
                    foreach($users as $userfos){
                        if( $userfos->getUsername() == $user->getUsername()){
                            $errorUsername = "Le nom d'utilisateur est déjà utilisé" ;
                        }elseif($userfos->getEmail() == $user->getEmail()){
                            $errorEmail = "L'adresse e-mail est déjà utilisée" ;
                        }
                    }
                    return $this->render('FaculteSuperAdminBundle:Adherent:modifier.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'Adherent'=>$Adherent,'errorUsername'=>$errorUsername,'errorEmail'=>$errorEmail
                    ));
                }
                return $this->redirect($this->generateUrl('faculte_super_admin_adherent'));
            }
        }

        return $this->render('FaculteSuperAdminBundle:Adherent:modifier.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView(),'Adherent'=>$Adherent));

    }

    public function supprimerAdherentAction($idAd, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->getRepository('FaculteAdminBundle:Adherent')->findOneById($idAd);
        $em->remove($adherent);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_super_admin_liste_adherent'));


    }

    public function suitAdherentAction($idAd)
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->getRepository('FaculteAdminBundle:Adherent')->findOneById($idAd);
        return $this->render('FaculteASuperdminBundle:Adherent:suit.html.twig', array('Adherent' => $adherent));

    }



}