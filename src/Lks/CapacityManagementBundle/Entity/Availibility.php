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
		return $member;
	}

	public function setMember($member)
	{
		$this->member = $member;
	}

	public function getAvailibilityDate()
	{
		return $availibilityDate;
	}

	public function setAvailibilityDate($availibilityDate)
	{
		$this->availibilityDate = $availibilityDate;
	}

}