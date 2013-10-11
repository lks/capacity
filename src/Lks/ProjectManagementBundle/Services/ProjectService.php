<?php

namespace Lks\ProjectManagementBundle\Services;

use Lks\ProjectManagementBundle\Entity\Project;

class ProjectService
{
	protected $projectDao;

    public function __construct($projectDao)
    {
        $this->projectDao = $projectDao;
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

	public function assignProject($projectId, $memberId)
	{
		return null;
	}

	/**
     * list all open projects
     *
     * @return Array of Project object
     */
	public function automaticPlanProject($project)
	{
		//get next availibility of the member selected
		$member = $project->getMember();

		//sort the projects list
		$availibilityDate = $member->getAvailibilityDate($project->getId());
		
		//compute the begin date and the end date
		$project->setBeginDate($availibilityDate);
		$endTmpDate = clone $availibilityDate;
		$endTmpInterval = new \DateInterval('P'.$project->getEstimation().'D');
		$project->setEndDate($endTmpDate->add($endTmpInterval));

		return $project;

	}
}