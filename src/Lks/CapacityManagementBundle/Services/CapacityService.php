<?php

namespace Lks\CapacityManagementBundle\Services;

use Lks\CapacityManagementBundle\Entity\Capacity;
use Lks\CapacityManagementBundle\Entity\Member;
use Lks\CapacityManagementBundle\Entity\ProjectLight;
use Lks\CapacityManagementBundle\Entity\Project;



class CapacityService
{
	protected $memberService;
	protected $projectService;

    public function __construct($memberService, $projectService)
    {
        $this->memberService = $memberService;
        $this->projectService = $projectService;
    }

    /**
     * Compute the capacity planning in function of projects list and members list
     *
     * @param Boolean True, add the suggestion for the open projects, false, no adding
     * @param Integer Number of day of the period
     * @return Array of Capacity entity
     */
    public function computeCapacityPlanning($suggestion = false, $period = 60)
    {
    	// List of members
    	$listMembers = $memberService->listMembers();

    	// Create the capacity objects
    	$capacities = array();
    	foreach($listMembers as $member)
    	{
    		$capacity = new Capacity();
	    	$capacity->setMember($member);
	    	
	    	// Compute for each project the percent of availibility
	    	$projects = $member->getProjects();
	    	foreach($projects as $project)
	    	{
	    		
	    	}
    	}


    	$project = new Project();
    	$project->setName('Test');
    	$project->setBeginDate(new \DateTime('NOW'));
    	$capacity1->addProject(new ProjectLight($project, new \DateTime('NOW')));
    	$capacity2 = new Capacity();
    	return array($capacity1, new Capacity());
    }

    protected function convertDateToPercent()
    {}
}