<?php

namespace Lks\CapacityManagementBundle\Services;

interface ICapacityService
{
	
	/**
	 * Compute the availibility of each member. In function of the endDate of the project assigned to the member,
	 * we can identify the availibility date.
	 *
	 * @return array of Availibity Object
	 */
	public function listMembersAvailibilities();

	/**
	 * In function of the project assigned, the priority and the availibility of each member, 
	 * we compute the capacity planning of all members for the next 60 days.
	 *
	 * @return array of CapacityPlanning Object
	 */
	public function getCapacityPlanning();
}