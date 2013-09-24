<?php

namespace Lks\CapacityManagementBundle\Services;

class CapacityService
{
	/**
	 * Find the next availibility of all members
	 */
	function findNextAvailibility()
	{
		//Query all members to find the availibility 
		$em = $this->getDoctrine()->getEntityManager();
		$query = $em->createQuery(
		    'SELECT p
		    FROM LksMemberManagementBundle:Member m, LksProjectManagementBundle:Project
		    WHERE p.price > :price
		    ORDER BY p.price ASC'
		)->setParameter('price', '19.99');
	}
}