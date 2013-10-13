<?php

namespace Lks\CapacityManagementBundle\Services;

use Lks\CapacityManagementBundle\Entity\Project;
use Lks\CapacityManagementBundle\Exception\NotFoundException;
use Lks\CapacityManagementBundle\Entity\Member;

class ProjectService
{
	protected $projectDao;
	protected $memberService;

    public function __construct($projectDao, $memberService)
    {
        $this->projectDao = $projectDao;
        $this->memberService = $memberService;
    }

    /**
     * list all open projects
     *
     * @return Array of Project object
     */
	public function listOpenProjects()
	{
        return $this->projectDao->listProjects(array('member' => null));
	}

	/**
	 * Assigne the given member to the given project. This method will get the next availibility date
	 * of the member and will compute the end date of this project.
	 * 
	 * @param Integer Project id
	 * @param Integer Member id
	 * @return Project Object updated
	 */
	public function assignProject($projectId, $memberId)
	{
		$project = $this->projectDao->getProject($projectId);
		if($project == null)
		{
			throw new NotFoundException('Project with '.$projectId.' ID was not found in the database.');
		}
		$member = $this->memberService->getMember($memberId);
		$project->setMember($member);

		//compute the end date
		$availibilityDate = $this->memberService->getAvailibilityDateByMember($memberId);
		$project->setBeginDate($availibilityDate);
		$endDate = clone $availibilityDate;
		$project->setEndDate($endDate->add(new \DateInterval('P'.$project->getEstimation().'D')));

		return $project;
	}

	/**
     * list all open projects
     *
     * @return Array of Project object
     */
	// public function automaticPlanProject($project)
	// {
	// 	//get next availibility of the member selected
	// 	$member = $project->getMember();

	// 	//sort the projects list
	// 	$availibilityDate = $member->getAvailibilityDate($project->getId());
		
	// 	//compute the begin date and the end date
	// 	$project->setBeginDate($availibilityDate);
	// 	$endTmpDate = clone $availibilityDate;
	// 	$endTmpInterval = new \DateInterval('P'.$project->getEstimation().'D');
	// 	$project->setEndDate($endTmpDate->add($endTmpInterval));

	// 	return $project;

	// }
}