<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="tasks")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type = "string", length = 255)
     */
    private $title;

    /**
     * @ORM\Column(type = "string", length = 255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type = "string", length = 255)
     */
    private $status;

    /**
     * @ORM\Column(type = "datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type = "datetime")
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt():?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getUpdatedAt():?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user_id;

    /**
     * Get the value of user
     *
     * @return  User
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user
     *
     * @param  User  $user_id
     *
     * @return  self
     */ 
    public function setUserId(User $user_id) : self
    {
        $this->user_id = $user_id;

        return $this;
    }


}