<?php

namespace Lks\CapacityManagementBundle\Entity;

use Lks\ProjectManagementBundle\Entity\Project;

class ProjectDesign
{
	protected $project;
	protected $durationPercent;
	protected $beginPercent;

	public function getProject()
	{
		return $this->project;
	}

	public function setProject(Project $project)
	{
		$this->project = $project;
	}

	public function getDurationPercent()
	{
		return $this->durationPercent;
	}

	public function setDurationPercent($durationPercent)
	{
		$this->durationPercent = $durationPercent;
	}

	public function getBeginPercent()
	{
		return $this->beginPercent;
	}

	public function setBeginPercent($beginPercent)
	{
		$this->beginPercent = $beginPercent;
	}
}