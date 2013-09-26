<?php
namespace Lks\CapacityManagementBundle\Tests\Services;

use Lks\CapacityManagementBundle\Services\CapacityService;

class CapacityServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMembersAvailibilities()
    {
    	$this->assertEquals(42, 41);
    }

    public function testComputeAvailibilities()
    {
    	$serviceToTest = new CapacityService();

    	//Test Case 1
    	$beginDate = new \DateTime('2013-01-01');
    	$estimation = 4;

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('2013-01-05'), $testDate);

    }
}