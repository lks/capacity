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
	 * Update the given project. This method will get the next availibility date
	 * of the member and will compute the end date of this project.
	 * 
	 * @param Project 
	 * @return Project Object updated
	 */
	public function updateProject($project)
	{
		$member = $project->getMember();
		if($member != null)
		{
			//compute the end date
			$availibilityDate = $this->memberService->getAvailibilityDateByMember($member->getId());
			$diff = $availibilityDate->diff($project->getBeginDate());
            if(!($diff->days > 0 && $diff->invert))
            {
            	$availibilityDate = $project->getBeginDate();
            }
			$project->setBeginDate($availibilityDate);
			$endDate = clone $availibilityDate;
			$project->setEndDate($endDate->add(new \DateInterval('P'.$project->getEstimation().'D')));
		}
		$this->projectDao->save($project);
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