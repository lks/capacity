<?php
namespace Lks\CapacityManagementBundle\Tests\Services;

use Lks\CapacityManagementBundle\Services\CapacityService;

class CapacityServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMembersAvailibilities()
    {
    	$this->assertEquals(42, 42);
    }

    public function testComputeAvailibilities()
    {
    	$serviceToTest = new CapacityService();

    	//Test Case 1
    	$beginDate = new \DateTime('2013-01-01');
    	$estimation = 4;

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('2013-01-05'), $testDate);

    	//Test Case 2
    	$beginDate = new \DateTime('2013-01-01');
    	$estimation = 6;

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('2013-01-09'), $testDate);

    }

    public function testComputeAvailibilitiesError()
    {
    	$serviceToTest = new CapacityService();

    	//Test Case 1
    	$beginDate = null;
    	$estimation = null;	

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('NOW'), $testDate);

    	//Test Case 2
    	$beginDate = null;
    	$estimation = 5;	

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('NOW'), $testDate);

    	//Test Case 3
    	$beginDate = 7;
    	$estimation = null;	

    	$testDate = $serviceToTest->computeAvailibilities($beginDate, $estimation);
    	$this->assertEquals(new \DateTime('NOW'), $testDate);

    }
}