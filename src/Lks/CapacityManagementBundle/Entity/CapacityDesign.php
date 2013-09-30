<?php

namespace Lks\CapacityManagementBundle\Entity;

use Lks\CapacityManagementBundle\Entity\ProjectDesign;

class capacityDesign
{
	protected $member;
	protected $projectDesigns;

	function __construct()
	{
		$member = null;
		$projectDesigns = array();
	}

	public function getMember()
	{
		return $this->member;
	}

	public function setMember($member)
	{
		$this->member = $member;
	}

	public function getProjectDesigns()
	{
		return $this->projectDesigns;
	}

	public function setProjectDesigns(array $projectDesigns)
	{
		$this->projectDesigns = $projectDesigns;
	}

	public function addProjectDesign($projectDesign)
	{
		$this->projectDesigns[count($this->projectDesigns)] = $projectDesign;
	}

}