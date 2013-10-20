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
        $memberService = $this->get('memberService');
        $members = $memberService->listMembers();

        // Compute the capacity planning
        $capacities = array();
        foreach($members as $member)
        {
            $cap = new Capacity();
            $member->setAvailibilityDate();
            $cap->setMember($member);
            foreach($member->getProjects() as $project)
            {
                $cap->addProject(new ProjectLight($project, new \DateTime('NOW')));
            }
            $capacities[count($capacities)] = $cap;
        }

        // Get the list of the open projects
        $projectService = $this->get('projectService');
        $projects = $projectService->listOpenProjects();

        return $this->render('LksCapacityManagementBundle:Default:index.html.twig', 
            array(
                'members' => $members,
                'capacities' => $capacities,
                'projects' => $projects,
                ));
    }
}
