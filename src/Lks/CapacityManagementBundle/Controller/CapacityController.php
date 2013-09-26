<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CapacityController extends Controller
{
    public function generateAction(Request $request)
    {
    	$logger = $this->get('logger');

    	//Query all member to determine the availibility
    	$repository = $this->getDoctrine()
            ->getRepository('LksMemberManagementBundle:Member');
        
        // Check the availibility of a member
        $members = $repository->findAll();

        $capacityService = $this->get('capacity');
        $availibilities = $capacityService->getMembersAvailibilities($members);

        return $this->render('LksCapacityManagementBundle:Default:index.html.twig', array('availibilities' => $availibilities));
    }
}
