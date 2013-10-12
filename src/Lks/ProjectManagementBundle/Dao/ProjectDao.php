<?php

namespace Lks\ProjectManagementBundle\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Lks\ProjectManagementBundle\Entity\Project;
use Doctrine\Common\Collections\Criteria;

class ProjectDao
{
	protected $em;
	protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('LksProjectManagementBundle:Project');
    }

    public function getProject($id)
    {
        return $this->repository->find($id);
    }

	public function listProjects($params)
	{
        return $this->repository->findBy($params);
	}

    public function save($project)
    {
        $this->em->persist($project);
        $this->em->flush();
        return $project;
    }
}