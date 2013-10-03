<?php
namespace Lks\MemberManagementBundle\Entity;

use Lks\ProjectManagementBundle\Entity\Project;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="member")
 */
class Member
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
	protected $firstname;

	/**
     * @ORM\Column(type="string", length=100)
     */
	protected $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $availibilityDate;

    /**
     * @ORM\OneToMany(targetEntity="Lks\ProjectManagementBundle\Entity\Project", mappedBy="member")
     */
    protected $projects;

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
     * Set firstname
     *
     * @param string $firstname
     * @return Member
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Member
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add projects
     *
     * @param \Lks\ProjectManagementBundle\Entity\Project $projects
     * @return Member
     */
    public function addProject(\Lks\ProjectManagementBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Lks\ProjectManagementBundle\Entity\Project $projects
     */
    public function removeProject(\Lks\ProjectManagementBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Get availibilityDate
     *
     * @return \DateTime 
     */
    public function getAvailibilityDate()
    {
        //@todo : sort the projects list
        $projects = array();
        $projectsTh = $this->getProjects();
        foreach($projectsTh as $project)
        {
            $projects[count($projects)] = $project;
        }

        $this->availibilityDate = new \DateTime('NOW');
        if((isset($projects)) && (count($projects) > 0))
        {
            usort($projects, function($a, $b)
                    {
                        return $a > $b;
                    });
            $this->availibilityDate = $projects[0];
        }

        return $this->availibilityDate;
    }
}