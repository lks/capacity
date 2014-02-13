<?php

namespace Lks\CapacityManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;
use Lks\CapacityManagementBundle\Entity\Member;
use Lks\CapacityManagementBundle\Entity\Project;

class ProjectService extends Units\Test
{
	/**
	 * listOpenProjects method test for the use case 1:
	 * No project is open so the list returned must be empty
	 */
	public function testListOpenProjectsCase1()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();

		$this->calling($mockProjectDao)->listProjects = array();

		$projectService = new \Lks\CapacityManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
		$listProjects = $projectService->listOpenProjects();
		$this
			->array($listProjects)
				->isEmpty()
			->mock($mockProjectDao)
        		->call('listProjects')
            		->once()
        ;
	}

	/**
	 * listOpenProjects method test for the use case 2:
	 * 2 projects are found with no member assgined, so the list must contain two items
	 */
	public function testListOpenProjectsCase2()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();

        $this->calling($mockProjectDao)->listProjects = array($this->createProject(), $this->createProject());

		$projectService = new \Lks\CapacityManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
		$listProjects = $projectService->listOpenProjects();
		$this
			->array($listProjects)
				->hasSize(2)
			->mock($mockProjectDao)
        		->call('listProjects')
            		->once()
        ;
	}

	/**
	 * assignProject method test for the use case 1:
	 * Assign a member to this project with a begin date at 2013-12-11 and an end date at 2013-12-13
	 */
	public function testUpdateProjectCase1()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();

		$memberTmp = $this->createMember();
		$projectTmp = $this->createProject(2);
        $this->calling($mockProjectDao)->getProject = $projectTmp;
        $this->calling($mockMemberService)->getMember = $memberTmp;
        $this->calling($mockMemberService)->getAvailibilityDateByMember = new \DateTime('2013-12-11');

        $projectService = new \Lks\CapacityManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
        $projectTmp->setMember($memberTmp);
        $project = $projectService->updateProject($projectTmp);
        $this
        	->object($project)
        		->isInstanceOf('Lks\CapacityManagementBundle\Entity\Project')
        	->variable($project->getMember())
        		->isEqualTo($memberTmp)
        	->dateTime($project->getBeginDate())
        		->hasDate('2013', '12', '11')
        	->dateTime($project->getEndDate())
        		->hasDate('2013', '12', '13')
        ;
	}

	public function testUpdateProjectExceptionNoProject()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();

		$this->calling($mockProjectDao)->getProject = null;
		$projectService = new \Lks\CapacityManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);

        $this
        	->exception(
        			 function() use($projectService) {
			            $projectService->updateProject(null);
			        }
        		)
        		->isInstanceOf('Lks\CapacityManagementBundle\Exception\NotFoundException')
        ;
	}


	public function testListAssignedProjects()
	{
		$mockProjectDao = new \mock\ProjectDao();
		

	}

	private function createProject($estimation = 5)
	{
		$project = new Project();
		$project->setEstimation($estimation);
		return $project;
	}

	private function createMember()
	{
		return new Member();
	}
}