<?php

namespace Lks\CapacityManagementBundle\Tests\Units\Services;

use atoum\AtoumBundle\Test\Units;

class CapacityService extends Units\Test
{
	public function testComputeCapacityPlanning()
	{
		$this->mockGenerator->generate('MemberService');
		$mockMemberService = new \mock\MemberService();
		$this->mockGenerator->generate('ProjectService');
		$mockProjectService = new \mock\ProjectService();

		$capacityService = new \Lks\CapacityManagementBundle\Services\CapacityService($mockMemberService, $mockProjectService);
		$listCapacities = $capacityService->computeCapacityPlanning();
		$this
			->array($listCapacities)
				->isNotEmpty()
		;
	}
	
}