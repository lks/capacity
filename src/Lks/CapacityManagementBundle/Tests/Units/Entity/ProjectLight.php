<?php

namespace Lks\CapacityManagementBundle\Tests\Units\Entity;

use Lks\CapacityManagementBundle\Entity\Project;
use atoum\AtoumBundle\Test\Units;

class ProjectLight extends Units\Test
{
	public function testConstruct()
	{
		// Project definition:
		// name: Test 1
		// Begin date: 21-10-2013
		// End date: 04-11-2013
		// Estimation: 10
		$project = $this->generateProject("Test 1", 
										new \DateTime('21-10-2013'), 
										new \DateTime('01-11-2013'),
										10);
		$currentDate = new \DateTime('26-10-2013');
		$this->
			if($projectLight = new \Lks\CapacityManagementBundle\Entity\ProjectLight($project, $currentDate))
				->string($projectLight->getName())
					->contains("Test 1")
		;
	} 

	protected function generateProject($name, $beginDate, $endDate, $estimation)
	{
		$project = new Project();
		$project->setName($name);
		$project->setBeginDate($beginDate);
		$project->setEndDate($endDate);
		$project->setEstimation($estimation);

		return $project;
	}
}