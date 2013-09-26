<?php

namespace Lks\CapacityManagementBundle\Services;

use Lks\CapacityManagementBundle\Entity\Availibility;

class CapacityService
{
	
	function __construct() {}

	public function getMembersAvailibilities($members)
	{
		//list of availibility of the members
        $availibilities = array();

        for($i=0; $i<count($members); $i++)
        {
        	$member = $members[$i];

        	$availibility = new Availibility();
        	$availibility->setMember($member);

        	for($j=0; $j<count($member->getProjects()); $j++)
        	{
        		$project = $member->getProjects()[$j];
        		$endDate = $this->computeAvailibilities($project->getBeginDate(), $project->getEstimation());

        		if($availibility->getAvailibilityDate() != null)
        		{
        			if ($availibility->getAvailibilityDate() < $endDate) 
        			{
        				$availibility->setAvailibilityDate($endDate);
        			}
        		} else {
        			$availibility->setAvailibilityDate($endDate);
        		}
        	}
        	$availibilities[$i] = $availibility;
        }
        return $availibilities;
	}

	/**
	 * Compute the date of the member avalibility
	 *
	 * @param beginDate Begin date of the project
	 * @param estimation Estimation defined
	 */
	protected function computeAvailibilities($beginDate, $estimation) 
	{
		$availibilityDate = new \DateTime('NOW');
		if($beginDate != null && $estimation != null)
		{
			$availibilityDate = $beginDate;

			if($estimation/5 > 1){
				$estimation = $estimation+2;
			}

			$availibilityDate->add(new \DateInterval('P'.$estimation.'D'));
		}
		return $availibilityDate;
	}
}