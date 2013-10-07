<?php

namespace Lks\MemberManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;

class MemberService extends Units\Test
{
	public function testListMembers()
	{
		$this->mockGenerator->generate('MemberDao');
		$mockMemberDao = new \mock\MemberDao();

		$this->calling($mockMemberDao)->listMembers = null;

		if($memberService = new \Lks\MemberManagementBundle\Services\MemberService($mockMemberDao))

	}
}