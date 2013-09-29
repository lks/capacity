<?php

namespace Lks\MemberManagementBundle\Services;

class MemberService
{
	
	protected $memberDao;

    public function __construct($memberDao)
    {
        $this->memberDao = $memberDao;
    }

    public function listMembers()
    {
    	return $this->memberDao->listMembers();
    }
}