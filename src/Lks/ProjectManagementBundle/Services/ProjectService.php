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
}