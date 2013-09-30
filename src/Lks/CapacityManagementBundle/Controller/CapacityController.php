<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lks\CapacityManagementBundle\Services\CapacityService;
use Lks\ProjectManagementBundle\Services\ProjectService;

class CapacityController extends Controller
{
    public function generateAction(Request $request)
    {
        $projectDao = $this->get('projectDao');
        $memberDao = $this->get('memberDao');
        $capacityService = new CapacityService($memberDao, $projectDao);

        $members = $capacityService->listMembersAvailibilities();
        $capacityPlanning = $capacityService->computeCapacityPlanning();

        $logger = $this->get('logger');
        $logger->info('durationPercent : '.$capacityPlanning[0]->getProjectDesigns()[0]->getDurationPercent());
        $logger->info('durationPercent : '.$capacityPlanning[0]->getProjectDesigns()[0]->getBeginPercent());

        //get project without Member and BeginDate
        // $projectDao = $this->get('projectDao');
        // $projectService = new ProjectService($projectDao);
        // $openProjects = $projectService->getOpenProjects();

        return $this->render('LksCapacityManagementBundle:Default:index.html.twig', 
            array(
                'members' => $members,
                'capacityPlanning' => $capacityPlanning,
                ));
    }
}
