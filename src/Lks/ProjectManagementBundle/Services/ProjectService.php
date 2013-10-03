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
		
		//compute the begin date and the end date
	}
}