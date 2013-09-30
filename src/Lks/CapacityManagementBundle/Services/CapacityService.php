<?php

namespace Lks\CapacityManagementBundle\Services;

use Lks\CapacityManagementBundle\Services\ICapacityService;
use Lks\CapacityManagementBundle\Entity\Availibility;
use Lks\CapacityManagementBundle\Entity\CapacityDesign;
use Lks\CapacityManagementBundle\Entity\ProjectDesign;
use Lks\MemberManagementBundle\Services\MemberService;
use Lks\ProjectManagementBundle\Services\ProjectService;

class CapacityService implements ICapacityService
{
	protected $memberDao;
	protected $projectDao;

	public function __construct($memberDao, $projectDao)
	{
		$this->memberDao = $memberDao;
		$this->projectDao = $projectDao;
	}

	public function listMembersAvailibilities()
	{
		$memberService = new MemberService($this->memberDao);
		return $memberService->listMembers();
	}

	public function computeCapacityPlanning()
	{
		$memberService = new MemberService($this->memberDao);
		$projectService = new ProjectService($this->projectDao);

		$nbMaxDay = 60;
		$members = $memberService->listMembers();
		$designs = array();
		$currentDate = new \DateTime('NOW');
		foreach($members as $member)
		{
			$cap = new CapacityDesign();
			$cap->setMember($member);
			foreach($member->getProjects() as $project)
			{
				$cap->addProjectDesign($this->generateProjectDesign($project, $currentDate));
			}
			$designs[count($designs)] = $cap;
		}
		return $designs;
	}

	/**
	 * Create the ProjectDesign Object from the project and the currentDate.
	 * The percent of the beginning form and the width of the form.
	 *
	 * @param ProjectDesign
	 */
	private function generateProjectDesign($project, \DateTime $currentDate)
	{
		$beginPercent = 0;
		$durationPercent = 0;
		$projectDesign = new ProjectDesign();
		$projectDesign->setProject($project);

		//compute the percent of the project design
		$beginDate = $project->getBeginDate();
		if($beginDate != null &&  ($beginDate->diff($currentDate)->days < 0))
		{
			$durationPercent = $projectroject->getEndDate()->diff($currentDate);
			$beginPercent = 0;	
		} else {
			$durationPercent = $project->getEndDate()->diff($project->getBeginDate());
			$beginPercent = $project->getBeginDate()->diff($currentDate);
		}
		$projectDesign->setDurationPercent($durationPercent);
		$projectDesign->setBeginPercent($beginPercent);
	}


	public function getMembersAvailibilities($members)
	{
		//list of availibility of the members
        $availibilities = array();

        for($i=0; $i<count($members); $i++)
        {
        	$member = $members[$i];

        	$availibility = new Availibility();
        	$availibility->setMember($member);
        	$projects = $member->getProjects();

        	//Compute the endDate of the project and in function of the endDate of each project,
        	// we get the last endDate only.
        	foreach ($projects as $project)
        	{
        		$endDate = $this->computeAvailibilities($project->getBeginDate(), $project->getEstimation());
        		if($availibility->getAvailibilityDate() != null)
        		{
        			if ($availibility->getAvailibilityDate() < $endDate) 
        			{
        				$availibility->setAvailibilityDate($endDate);
        			}
        		} 
        		else 
        		{
        			$availibility->setAvailibilityDate($endDate);
        		}
        	}
        	$availibilities[$i] = $availibility;
        }
        return $availibilities;
	}

	/**
	 * Compute the date of the member avalibility
	 *
	 * @param beginDate Begin date of the project
	 * @param estimation Estimation defined
	 */
	public function computeAvailibilities($beginDate, $estimation) 
	{
		$availibilityDate = new \DateTime('NOW');
		if($beginDate != null && $estimation != null)
		{
			$availibilityDate = $beginDate;

			if($estimation/5 > 1){
				$estimation = $estimation+2;
			}

			$availibilityDate->add(new \DateInterval('P'.$estimation.'D'));
		}
		return $availibilityDate;
	}
}