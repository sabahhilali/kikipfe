<?php

namespace Faculte\CoachBundle\Controller;

use Faculte\AdminBundle\Form\CoachType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()

    {
        return $this->render('FaculteCoachBundle:Default:index.html.twig');
    }

}
