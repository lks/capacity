<?php
namespace Lks\ProjectManagementBundle\Entity;

use Lks\MemberManagementBundle\Entity\Member;

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
     * @ORM\Column(type="decimal")
     */
    protected $estimation;

    /**
     * @ORM\Column(type="string", length=3)
     */
	protected $priority;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $beginDate;

	/**
     * @ORM\ManyToOne(targetEntity="Lks\MemberManagementBundle\Entity\Member", inversedBy="projects")
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
     * @param \Lks\MemberManagementBundle\Entity\Member $member
     * @return Project
     */
    public function setMember(\Lks\MemberManagementBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \Lks\UserManagementBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set estimation
     *
     * @param float $estimation
     * @return Project
     */
    public function setEstimation($estimation)
    {
        $this->estimation = $estimation;
    
        return $this;
    }

    /**
     * Get estimation
     *
     * @return float 
     */
    public function getEstimation()
    {
        return $this->estimation;
    }

    /**
     * Set priority
     *
     * @param string $priority
     * @return Project
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return string 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set beginDate
     *
     * @param \DateTime $beginDate
     * @return Project
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    
        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime 
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }
}