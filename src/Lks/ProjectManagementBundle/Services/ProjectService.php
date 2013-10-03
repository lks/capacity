<?php

namespace Lks\ProjectManagementBundle\Services;

use Lks\ProjectManagementBundle\Entity\Project;

class ProjectService
{

	protected $em;
	protected $projectDao;

    public function __construct($projectDao)
    {
        $this->projectDao = $projectDao;
    }

	public function getOpenProjects()
	{
        return $this->projectDao->getProjects(array('member' => null));
	}

	public function planProject(Project $project)
	{
		//get next availibility of the member selected
		$member = $project->getMember();

		//sort the projects list
		$availibilityDate = $member->getAvailibilityDate();
		
		//compute the begin date and the end date
		$project->setBeginDate($availibilityDate);
		$endTmpDate = clone $availibilityDate;
		$project->setEndDate($endTmpDate->add(new \DateInterval('P'.$project->getEstimation().'D')));

		$this->projectDao->save($project);

	}
}