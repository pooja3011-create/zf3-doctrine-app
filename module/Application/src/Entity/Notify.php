<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 *
 * @ORM\Table(name="notify")
 * @ORM\Entity
 */
class Notify {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $message;
    
    /**
     * @ORM\Column(type="string")
     */
    private $subject;

    /**
     * @ORM\Column(name="date_created",type="datetime")  
     */
    private $dateCreated;
    
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getSubject() 
    {
        return $this->subject;
    }

    public function setSubject($subject) 
    {
        $this->subject = $subject;
        return $this;
    }
    
    public function getMessage() 
    {
        return $this->message;
    }

    public function setMessage($message) 
    {
        $this->message = $message;
        return $this;
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
