<?php
namespace Lks\ProjectManagementBundle\Entity;

use Lks\UserManagementBundle\Entity\Member;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class Project
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

	/**
     * @ORM\Column(type="string", length=100)
     */
	protected $name;

	/**
     * @ORM\Column(type="text")
     */
	protected $description;

	/**
     * @ORM\ManyToOne(targetEntity="Lks\UserManagementBundle\Entity\Member", inversedBy="projects")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
	protected $member;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set member
     *
     * @param \Lks\ProjectManagementBundle\Entity\Member $member
     * @return Project
     */
    public function setMember(\Lks\ProjectManagementBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \Lks\ProjectManagementBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }
}