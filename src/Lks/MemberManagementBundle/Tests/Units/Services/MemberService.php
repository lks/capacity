<?php

namespace Lks\MemberManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;

class MemberService extends Units\Test
{
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
}