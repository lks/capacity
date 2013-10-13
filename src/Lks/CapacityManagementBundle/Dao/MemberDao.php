<?php

namespace Lks\CapacityManagementBundle\Dao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class MemberDao
{
	protected $em;
	protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('LksCapacityManagementBundle:Member');
    }

    public function listMembers($params = null)
	{
		$members = null;
		if($params == null)
		{
			$members = $this->repository->findAll();
		} else {
			$members = $this->repository->findBy($params);
		}

        return $members;
	}

	public function getMember($id)
	{
		$member = $this->repository->find($id);
        return $member;
	}
}