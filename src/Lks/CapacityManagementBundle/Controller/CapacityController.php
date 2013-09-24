<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CapacityController extends Controller
{
    public function generateAction(Request $request)
    {
    	var $availibility;

    	//Query all member to determine the availibility
    	$repository = $this->getDoctrine()
            ->getRepository('LksMemberManagementBundle:Member');

        $members = $repository->findAll();

        return $this->render('LksCapacityManagementBundle:Default:index.html.twig');
    }
}
