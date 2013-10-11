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
     * @param \Lks\ProjectManagementBundle\Entity\Project $project
     * @return Member
     */
    public function addProject(\Lks\ProjectManagementBundle\Entity\Project $project)
    {
        $this->projects[count($this->projects)] = $project;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Lks\ProjectManagementBundle\Entity\Project $projects
     */
    public function removeProject(\Lks\ProjectManagementBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
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
            $tmpId = $project->getId();
            $projects[count($projects)] = $project;
        }

        $this->availibilityDate = new \DateTime('NOW');
        if((isset($projects)) && (count($projects) > 0))
        {
            usort($projects, function($a, $b)
                    {
                        return $a < $b;
                    });
            $this->availibilityDate = new \DateTime($projects[0]->getEndDate());
            $this->availibilityDate->add(new \DateInterval('P01D'));
        }

        return $this->availibilityDate;
    }
}