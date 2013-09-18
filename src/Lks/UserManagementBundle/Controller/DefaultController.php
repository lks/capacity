<?php

namespace Lks\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LksUserManagementBundle:Default:index.html.twig', array('name' => $name));
    }
}
