<?php

namespace Lks\ProjectManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;
use Lks\MemberManagementBundle\Entity\Member;
use Lks\ProjectManagementBundle\Entity\Project;

class ProjectService extends Units\Test
{
	public function testListOpenProjects()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();

		$this->calling($mockProjectDao)->listProjects = array();

		$projectService = new \Lks\ProjectManagementBundle\Services\ProjectService($mockProjectDao);
		$listProjects = $projectService->listProjects();
		$this
			->array($listProjects)
				->isEmpty()
			->mock($mockProjectDao)
        		->call('listProjects')
            		->once()
        ;
	}
}