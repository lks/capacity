<?php

namespace Lks\CapacityManagementBundle\Entity;

use Lks\CapacityManagementBundle\Entity\Member;
use Lks\CapacityManagementBundle\Entity\ProjectLight;

class Capacity
{
	protected $member;
	protected $projects;

	/**
     * Get member
     *
     * @return Member 
     */
	public function getMember()
	{
		return $this->member;
	}

	/**
     * Set member
     *
     * @return Member 
     */
	public function setMember($member)
	{
		$this->member = $member;
	}

	/**
     * Get Project
     *
     * @return Array of ProjectLight 
     */
	public function getProjects()
	{
		return $this->projects;
	}

	/**
     * Set projects
     *
     * @return array of ProjectLight 
     */
	public function setProjects($projects)
	{
		$this->projects = $projects;
	}

	/**
     * Add projects light to the list
     *
     * @return array of ProjectLight 
     */
	public function addProject($project)
	{
		if(!isset($this->projects))
		{
			$this->projects = array();
		}
		$this->projects[count($this->projects)] = $project;
	}

}