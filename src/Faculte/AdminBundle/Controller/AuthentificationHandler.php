<?php
namespace Faculte\AdminBundle\Controller;
use Faculte\AdminBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthentificationHandler  implements  AuthenticationSuccessHandlerInterface
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $referer = $request->headers->get('referer');
        // retrieve user and session id
        /**@var $user User */
        $user = $token->getUser();
        $idU = $user->getId();
        $Roles = $token->getUser()->getRoles();

        if($user->hasRole('ROLE_ADMIN')){
            return new RedirectResponse($this->router->generate('faculte_admin_homepage'));
        }
        elseif ($user->hasRole('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($this->router->generate('faculte_super_admin_homepage'));
        }
        elseif ($user->hasRole('ROLE_COACH')) {
            return new RedirectResponse($this->router->generate('faculte_coach_homepage'));
        }
        elseif ($user->hasRole('ROLE_ADHERANT')) {
            return new RedirectResponse($this->router->generate('faculte_adherant_homepage'));
        }
        elseif ($user->hasRole('ROLE_CLIENT')) {
            return new RedirectResponse($this->router->generate('faculte_client_homepage'));
        }
    }


}

