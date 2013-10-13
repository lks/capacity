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
				->hasSize(2)
			->object($listCapacities[0])
				->isInstanceOf('Lks\CapacityManagementBundle\Entity\Capacity')
			->object($listCapacities[0]->getMember())
				->isInstanceOf('Lks\CapacityManagementBundle\Entity\Member')

		;
	}
	
}