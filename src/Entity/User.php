<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     *
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     *
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     *
     * 
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     *
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var Task[]|ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }


    public function getId():?int
    {
        return $this->id;
    }


    public function getLastName():?string
    {
        return $this->lastName;
    }


    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }


    public function getFirstName():?string
    {
        return $this->firstName;
    }


    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }


    public function getEmail():?string
    {
        return $this->email;
    }


    public function setEmail(string $email):self
    {
        $this->email = $email;

        return $this;
    }


    public function getPassword():?string
    {
        return $this->password;
    }


    public function setPassword(string $password):self
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt= new \DateTime();
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
     * Get the value of tasks
     *
     * @return  Task[]|ArrayCollection
     */ 
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     * 
     * @return self
     */
    public function addTask(Task $task) : self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }

        return $this;
    }

    /**
     * @param Task $task
     * 
     * @return self
     */
    public function removeTask(Task $task) : self
    {
        $this->tasks->removeElement($task);

        return $this;
    }


}