<?php

namespace Lks\CapacityManagementBundle\Services;

use Lks\CapacityManagementBundle\Services\ICapacityService;
use Lks\CapacityManagementBundle\Entity\Availibility;
use Lks\CapacityManagementBundle\Entity\Capacity;
use Lks\MemberManagementBundle\Services\MemberService;
use Lks\ProjectManagementBundle\Services\ProjectService;

class CapacityService implements ICapacityService
{
	protected $memberDao;
	protected $projectDao;
	protected $logger;

	public function __construct($memberDao, $projectDao, $logger)
	{
		$this->memberDao = $memberDao;
		$this->projectDao = $projectDao;
		$this->logger = $logger;
	}

	public function listMembersAvailibilities()
	{
		$memberService = new MemberService($this->memberDao);
		return $memberService->listMembers();
	}

	public function listMembers()
	{
		$memberService = new MemberService($this->memberDao);
		return $memberService->listMembers();
	}

	public function getCapacityPlanning()
	{
		$memberService = new MemberService($this->memberDao);
		$projectService = new ProjectService($this->projectDao);

		$maxDateTimeStamp;
		$members = $memberService->listMembers();
		$capacities = array();

		foreach($members as $member)
		{
			$cap = new Capacity();
			$cap->setMember($member);
			foreach($member->getProjects() as $project)
			{
				$cap->addProject(new ProjectLight($project));
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
	private function generateProjectDesign($project, \DateTime $currentDate, $maxDate)
	{
		$beginTimeStamp = 0;
		$durationTimeStamp = 0;
		$projectDesign = new ProjectDesign();
		$projectDesign->setProject($project);

		//compute the percent of the project design
		$beginDate = $project->getBeginDate();
		$this->logger->info('generateProjectDesign::project: '.$project->getName());
		

		if($currentDate->getTimestamp() > $beginDate->getTimestamp())
		{

			$durationTimeStamp = $project->getEndDate()->getTimestamp() - $currentDate->getTimestamp();
			$this->logger->info('generateProjectDesign::currentTimestamp: '.$currentDate->format('d-m-Y'));
			$this->logger->info('generateProjectDesign::maxDate: '.$maxDate->format('d-m-Y'));
			$beginTimeStamp = 0;	
		} else {
			$durationTimeStamp = $project->getEndDate()->getTimestamp() - $project->getBeginDate()->getTimestamp();
			$beginTimeStamp = $project->getBeginDate()->getTimestamp() - $currentDate->getTimestamp();
		}
		$projectDesign->setDurationPercent($this->computePercent($durationTimeStamp, ($maxDate->getTimestamp() - $currentDate->getTimestamp())));
		$projectDesign->setBeginPercent($this->computePercent($beginTimeStamp, ($maxDate->getTimestamp() - $currentDate->getTimestamp())));
		return $projectDesign;
	}

	private function computePercent($value, $valueMax)
	{
		$this->logger->info('computePercent::value: '.$value.' :: valueMax: '.$valueMax);
		return round(($value * 100 / $valueMax));
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