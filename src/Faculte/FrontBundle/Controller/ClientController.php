<?php
namespace Faculte\FrontBundle\Controller;



use Faculte\AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Entity\Client;
use Faculte\AdminBundle\Form\ClientType;
use Faculte\AdminBundle\Form\UserType;
use Faculte\AdminBundle\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends controller
{
    public function ajouterClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Client = new Client();
        $form = $this->createForm( ClientType::class, $Client);
        $form->handleRequest($request);
        $user = new User();
        $form2 = $this->createForm( UserType::class, $user);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->getMethod() == 'POST') {

                $Client = $form->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form2->getData();
                //ajouter role enseignant
                $role = array('ROLE_CLIENT');
                $user->setRoles($role);
                $user->setEnabled(true);
                //persist(mis en memoire l'objet $user
                $em->persist($user);
                //affecter l'objet user à l'enseignant
                $Client->setUser($user);
                //persist(mis en memoire l'objet $enseignant
                $Client->uploadPathFile();
                $em->persist($Client);

                try {

                    $em->flush();
                    $Client->movePathFile();

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
                    return $this->render('FaculteFrontBundle:Client:ajouter.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'errorUsername'=>$errorUsername,'errorEmail'=>$errorEmail
                    ));
                }


                return $this->redirect($this->generateUrl('faculte_front_homepage'));
            }
        }

        return $this->render('FaculteFrontBundle:Client:ajouter.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView()
        ));
    }

}