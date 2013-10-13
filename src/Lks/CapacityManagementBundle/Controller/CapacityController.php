<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lks\CapacityManagementBundle\Services\CapacityService;
use Lks\CapacityManagementBundle\Entity\ProjectLight;
use Lks\CapacityManagementBundle\Entity\Capacity;

class CapacityController extends Controller
{
    public function generateAction(Request $request)
    {
        $capacityService = $this->get('lks_capacity_management.capacity');

        $memberAvailibilities = $capacityService->listMembersAvailibilities();
        $members = $capacityService->listMembers();

        $capacities = array();
        foreach($members as $member)
        {
            $cap = new Capacity();
            $cap->setMember($member);
            foreach($member->getProjects() as $project)
            {
                $cap->addProject(new ProjectLight($project, new \DateTime('NOW')));
            }
            $capacities[count($capacities)] = $cap;
        }

        return $this->render('LksCapacityManagementBundle:Default:index.html.twig', 
            array(
                'members' => $members,
                'capacities' => $capacities,
                ));
    }
}
