<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Account {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Notary", inversedBy="account")
     * @ORM\JoinColumn(name="notary", referencedColumnName="id")
     */
    private $notary;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="float")
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity="AccountMove", mappedBy="account")
     */
    private $moves;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     * 
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updatedAt;

    public function __construct() {
        $this->moves = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set notary
     *
     * @param integer $notary
     *
     * @return Account
     */
    public function setNotary($notary) {
        $this->notary = $notary;

        return $this;
    }

    /**
     * Get notary
     *
     * @return int
     */
    public function getNotary() {
        return $this->notary;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Account
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set balance
     *
     * @param float $balance
     *
     * @return Account
     */
    public function setBalance($balance) {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return float
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * Add move
     *
     * @param \AppBundle\Entity\AccountMove $move
     *
     * @return Account
     */
    public function addMove(\AppBundle\Entity\AccountMove $move) {
        $this->moves[] = $move;

        return $this;
    }

    /**
     * Remove move
     *
     * @param \AppBundle\Entity\AccountMove $move
     */
    public function removeMove(\AppBundle\Entity\AccountMove $move) {
        $this->moves->removeElement($move);
    }

    /**
     * Get moves
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoves() {
        return $this->moves;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
    
    public function __toString() {
        return "ID: ".$this->getId()." | Account: ".$this->getDescription();
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Account
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Account
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    
    
}
