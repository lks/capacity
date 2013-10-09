<?php

namespace Lks\MemberManagementBundle\Tests\Units\Entity;
 
use Lks\ProjectManagementBundle\Entity\Project;
use atoum\AtoumBundle\Test\Units;
 
class Member extends Units\Test
{
    public function testGetAvailibilityDate()
    {
        //Project #1 creation
        $project1 = new Project();
        $project1->setEndDate('2013-11-21');
        $project2 = new Project();
        $project2->setEndDate('2013-12-02');

        $projects = array();
        $projects[0] = $project1;
        $projects[1] = $project2;

        $this
            ->if($member = new \Lks\MemberManagementBundle\Entity\Member())
            ->and($member->addProject($project1))
            ->and($member->addProject($project2))
                ->dateTime($member->getAvailibilityDate())
                    ->hasDate('2013', '12', '03')
        ;

        $this
            ->if($member = new \Lks\MemberManagementBundle\Entity\Member())
            ->and($member->addProject($project1))
                ->dateTime($member->getAvailibilityDate())
                    ->hasDate('2013', '11', '22')
        ;

        $currentDate = new \DateTime('NOW');

        $this
            ->if($member = new \Lks\MemberManagementBundle\Entity\Member())
                ->dateTime($member->getAvailibilityDate())
                    ->hasDate($currentDate->format('Y'), $currentDate->format('m'), $currentDate->format('d'))
        ;
    }
}