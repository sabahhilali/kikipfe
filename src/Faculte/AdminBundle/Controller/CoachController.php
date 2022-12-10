<?php

namespace Faculte\AdminBundle\Controller;

use Faculte\AdminBundle\Entity\Coach;
use Faculte\AdminBundle\Entity\User;
use Faculte\AdminBundle\Form\UserType;
use Faculte\AdminBundle\Form\CoachType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoachController extends Controller
{
    public function ajouterCoachAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Coach = new Coach();
        $form = $this->createForm( CoachType::class, $Coach);
        $form->handleRequest($request);
        $user = new User();
        $form2 = $this->createForm( UserType::class, $user);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->getMethod() == 'POST') {

                $Coach = $form->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form2->getData();
                //ajouter role enseignant
                $role = array('ROLE_COACH');
                $user->setRoles($role);
                $user->setEnabled(true);
                //persist(mis en memoire l'objet $user
                $em->persist($user);
                //affecter l'objet user à l'enseignant
                $Coach->setUser($user);
                //persist(mis en memoire l'objet $enseignant
                $Coach->uploadPathFile();
                $em->persist($Coach);

                try {

                    $em->flush();
                    $Coach->movePathFile();

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
                    return $this->render('FaculteAdminBundle:Coach:ajouter.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'errorUsername'=>$errorUsername,'errorEmail'=>$errorEmail
                    ));
                }


                return $this->redirect($this->generateUrl('faculte_admin_liste_coach'));
            }
        }

        return $this->render('FaculteAdminBundle:Coach:ajouter.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView()
        ));
    }

    public function listeCoachAction()
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findAll();
        return $this->render('FaculteAdminBundle:Coach:liste.html.twig', array('Coach' => $coach));

    }

    public function modifierCoachAction($idC,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Coach=$em->getRepository('FaculteAdminBundle:Coach')->findOneById($id);
        $user=$Coach->getUser();
        $form = $this->createForm(CoachType::class, $Coach);
        $form2 = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->isMethod('POST')) {
                $Coach = $form->getData();
                $user = $form2->getData();
                $em->persist($user);
                $Coach->setUser($user);
                $em->persist($Coach);
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
                    return $this->render('FaculteAdminBundle:Coach:modifier.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'Coach'=>$Coach,'errorUsername'=>$errorUsername,'errorEmail'=>$errorEmail
                    ));
                }
                return $this->redirect($this->generateUrl('faculte_admin_Coach'));
            }
        }

        return $this->render('FaculteAdminBundle:Coach:modifier.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView(),'Coach'=>$Coach));

    }

    public function supprimerCoachAction($idC, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneById($idC);
        $em->remove($coach);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_liste_coach'));
    }


    public function suitCoachAction($idC)
    {
        $em = $this->getDoctrine()->getManager();
        $coach = $em->getRepository('FaculteAdminBundle:Coach')->findOneById($idC);
        return $this->render('FaculteAdminBundle:Coach:suit.html.twig', array('Coach' => $coach));

    }


}