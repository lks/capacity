<?php

namespace Lks\MemberManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;
use Lks\MemberManagementBundle\Entity\Member;
use Lks\ProjectManagementBundle\Entity\Project;

class MemberService extends Units\Test
{
	/**
     * Test the list of member method
     */
	public function testListMembers()
	{
		$this->mockGenerator->generate('MemberDao');
		$mockMemberDao = new \mock\MemberDao();

		$this->calling($mockMemberDao)->listMembers = array();

		$memberService = new \Lks\MemberManagementBundle\Services\MemberService($mockMemberDao);
		$listMembers = $memberService->listMembers();
		$this
			->array($listMembers)
				->isEmpty()
			->mock($mockMemberDao)
        		->call('listMembers')
            		->once()
        ;
	}

	public function testGetAvailibilityDateOfMember()
	{
		$this->mockGenerator->generate('MemberDao');
		$mockMemberDao = new \mock\MemberDao();

		//nominal case
		$member = $this->createMember(new \DateTime('2013-12-10'), 5);
		$this->calling($mockMemberDao)->getMember = $member;

		$memberService = new \Lks\MemberManagementBundle\Services\MemberService($mockMemberDao);

		$availibilityDate = $memberService->getAvailibilityDateByMember(1);
		$this
			->dateTime($availibilityDate)
				->hasDate('2013','12','11')
			->mock($mockMemberDao)
        		->call('getMember')
            		->once()
        ;
	}

	/**
     * Method use for create a Member object to help the test case
     */
	private function createMember($availibilityDate, $nbProjects)
	{
		$member = new Member();
		$member->setFirstname('Firstname'.$nbProjects);
		$member->setLastname('Lastname'.$nbProjects);
		$newDate = clone $availibilityDate;

		$member->addProject($this->createProject(1, $availibilityDate));
		$member->addProject($this->createProject(2, $newDate->sub(new \DateInterval('P'.$nbProjects.'D'))));

		return $member;
	}

	public function createProject($id, $endDate)
	{
		$project = new Project();
		$project->setName('Name'.$id);
		$project->setEndDate($endDate);

		return $project;
	}
}