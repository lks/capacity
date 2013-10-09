<?php

namespace Lks\MemberManagementBundle\Tests\Units\Dao;

use atoum\AtoumBundle\Test\Units;

class MemberDao extends Units\Test
{
	public function testListMembers()
	{
		$this->mockGenerator->generate('MemberDao');
		$mockMemberDao = new \mock\MemberDao();
	}
}