<?php

namespace Lks\CapacityManagementBundle\Services;

class MemberService
{
	
	protected $memberDao;

    public function __construct($memberDao)
    {
        $this->memberDao = $memberDao;
    }

    /**
     * List of all members
     *
     * @return Array of Member object
     */
    public function listMembers()
    {
    	return $this->memberDao->listMembers();
    }

    public function getMember($id)
    {
        return $this->memberDao->getMember($id);
    }

    /**
     * Get the next availibility date for a given member
     *
     * @param Integer Member id
     * @return DateTime Next availibility date
     */
    public function getAvailibilityDateByMember($id)
    {
        $member = $this->memberDao->getMember($id);

        $projects = array();
        $projectsTh = $member->getProjects();
        foreach($projectsTh as $project)
        {
            $tmpId = $project->getId();
            $projects[count($projects)] = $project;
        }

        $availibilityDate = new \DateTime('NOW');
        if((isset($projects)) && (count($projects) > 0))
        {
            usort($projects, function($a, $b)
                    {
                        return $a > $b;
                    });
            $availibilityDate = $projects[0]->getEndDate();
            $availibilityDate->add(new \DateInterval('P01D'));
        }

        return $availibilityDate;
    }
}