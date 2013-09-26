<?php

namespace Lks\CapacityManagementBundle\Entity;

class Availibility
{
	protected $member;
	protected $availibilityDate;

	function __construct()
	{
		$member = null;
		$availibilityDate = null;
	}

	public function getMember()
	{
		return $this->member;
	}

	public function setMember($member)
	{
		$this->member = $member;
	}

	public function getAvailibilityDate()
	{
		return $this->availibilityDate;
	}

	public function setAvailibilityDate($availibilityDate)
	{
		$this->availibilityDate = $availibilityDate;
	}

}