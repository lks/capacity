<?php

namespace Lks\CapacityManagementBundle\Services;


class CapacityService
{
	protected $memberService;
	protected $projectService;

    public function __construct($memberService, $projectService)
    {
        $this->memberService = $memberService;
        $this->projectService = $projectService;
    }

    /**
     * Compute the capacity planning in function of projects list and members list
     *
     * @param Boolean True, add the suggestion for the open projects, false, no adding
     * @param Integer Number of day of the period
     * @return Array of Capacity entity
     */
    public function computeCapacityPlanning($suggestion = false, $period = 60)
    {
    	return null;
    }
}