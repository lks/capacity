<?php

namespace Lks\CapacityManagementBundle\Entity;

class ProjectLight
{
	protected $name;
	protected $duration;
	protected $startDelay;

	/**
	 * Constructor with the initial project parameter
	 *
	 */
	function __construct($project, $currentDate, $period = 60)
	{
		if($project != null)
		{
			$periodEndDate = (new \DateTime('NOW'))->add(new \DateInterval('P'.$period.'D'));
			$this->name = $project->getName();
			$projectBeginDate = $currentDate;
			if($project->getBeginDate() > $currentDate) 
			{
				$projectBeginDate = $project->getBeginDate();
			}

			$durationDay = $project->getEndDate()->diff($projectBeginDate)->days;
			$startDelayDay = $periodEndDate->diff($projectBeginDate)->days;
			$this->duration = $this->computePercent($durationDay, $period);

			//$this->startDelay =  $this->computePercent($startDelayDay, $period);
		}
	}
	 /**
     * Get name
     *
     * @return String 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param String 
     */
    public function setName($name)
    {
        $this->name = $name;
    } 

    /**
     * Get duration
     *
     * @return Integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set duration
     *
     * @param Integer 
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    } 

    /**
     * Get startDelay
     *
     * @return Integer 
     */
    public function getStartDelay()
    {
        return $this->startDelay;
    }

    /**
     * Set startDelay
     *
     * @param Integer 
     */
    public function setStartDelay($startDelay)
    {
        $this->startDelay = $startDelay;
    }

    private function computePercent($value, $valueMax)
	{
		return round(($value * 100 / $valueMax));
	}
}