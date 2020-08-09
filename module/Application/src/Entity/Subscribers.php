<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscribers
 *
 * @ORM\Table(name="subscribers",uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 * 
 */

class Subscribers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
     /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
  
    /** 
   * @ORM\Column(name="date_created",type="datetime")  
   */
    private $dateCreated;
    
    public function getId(): ?int
    {
        return $this->id;
    }
   
    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    // Return the date
    public function getDateCreated() 
    {
      return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) 
    {
      $this->dateCreated = $dateCreated;
    }
}
