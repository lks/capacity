<?php

namespace Lks\CapacityManagementBundle\Tests\Units\Entity;
 
use Lks\CapacityManagementBundle\Entity\Project;
use atoum\AtoumBundle\Test\Units;
 
class Member extends Units\Test
{
    public function testSetAvailibilityDate()
    {
        //Project #1 creation
        $project1 = new Project();
        $project1->setEndDate(new \DateTime('2013-11-21'));
        $project2 = new Project();
        $project2->setEndDate(new \DateTime('2013-12-02'));

        $projects = array();
        $projects[0] = $project1;
        $projects[1] = $project2;

        $this
            ->if($member = new \Lks\CapacityManagementBundle\Entity\Member())
            ->and($member->addProject($project1))
            ->and($member->addProject($project2))
                ->dateTime($member->setAvailibilityDate())
                    ->hasDate('2013', '12', '03')
        ;

        $this
            ->if($member = new \Lks\CapacityManagementBundle\Entity\Member())
            ->and($member->addProject($project1))
                ->dateTime($member->setAvailibilityDate())
                    ->hasDate('2013', '11', '22')
        ;

        $currentDate = new \DateTime('NOW');

        $this
            ->if($member = new \Lks\CapacityManagementBundle\Entity\Member())
                ->dateTime($member->setAvailibilityDate())
                    ->hasDate($currentDate->format('Y'), $currentDate->format('m'), $currentDate->format('d'))
        ;
    }
}