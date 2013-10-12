<?php

namespace Lks\ProjectManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;
use Lks\MemberManagementBundle\Entity\Member;
use Lks\ProjectManagementBundle\Entity\Project;

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

		$projectService = new \Lks\ProjectManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
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

		$projectService = new \Lks\ProjectManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
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
	public function testAssignProjectCase1()
	{
		$this->mockGenerator->generate('ProjectDao');
		$mockProjectDao = new \mock\ProjectDao();
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();

        $this->calling($mockProjectDao)->getProject = $this->createProject(2);
        $memberTmp = $this->createMember('2013-12-10');
        $this->calling($mockMemberService)->getMember = $memberTmp;
        $this->calling($mockMemberService)->getAvailibilityDateByMember = new \DateTime('2013-12-11');

        $projectService = new \Lks\ProjectManagementBundle\Services\ProjectService($mockProjectDao, $mockMemberService);
        $project = $projectService->assignProject(1, 1);
        $this
        	->object($project)
        		->isInstanceOf('Lks\ProjectManagementBundle\Entity\Project')
        	->variable($project->getMember())
        		->isEqualTo($memberTmp)
        	->dateTime($project->getBeginDate())
        		->hasDate('2013', '12', '11')
        	->dateTime($project->getEndDate())
        		->hasDate('2013', '12', '13')
        ;
	}

	private function createProject($estimation = 5)
	{
		$project = new Project();
		$project->setEstimation($estimation);
		return $project;
	}

	private function createMember($endDate)
	{
		$member = new Member();
		$project = new Project();
		$project->setEndDate(new \DateTime($endDate));
		$member->addProject($project);
		return $member;
	}
}