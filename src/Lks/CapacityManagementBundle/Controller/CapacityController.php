<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lks\CapacityManagementBundle\Entity\Availibility;

class CapacityController extends Controller
{
    public function generateAction(Request $request)
    {

    	//Query all member to determine the availibility
    	$repository = $this->getDoctrine()
            ->getRepository('LksMemberManagementBundle:Member');
        
        // Check the availibility of a member
        $members = $repository->findAll();

        //list of availibility of the members
        $availibilities = array();

        for($i=0; $i<count($members); $i++)
        {
        	$member = $members[$i];

        	$availibility = new Availibility();
        	$availibility->setMember($member);

        	for($j=0; $j<count($member->getProjects()); $j++)
        	{
        		$project = $member->getProjects()[$j];
        		$endDate = null;
        		//compute the availibility of a member
        		if($project->getEstimation()!= null && $project->getBeginDate() != null)
        		{
        			$endDate = add_date($project->getBeginDate(),$project->getEstimation());
        		}
        		if($availibility->getAvailibilityDate() != null && $availibility->getAvailibilityDate() < $endDate) 
        		{
        			$availibility->setAvailibilityDate($endDate);
        		}
        	}
        	$availibilities[$i] = $availibility;
        }


        return $this->render('LksCapacityManagementBundle:Default:index.html.twig', array('availibilities' => $availibilities));
    }
}
