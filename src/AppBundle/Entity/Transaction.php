<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Transaction {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="transactions")
     * @ORM\JoinColumn(name="service", referencedColumnName="id")
     */
    private $service;

    /**
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * @var float
     *
     * @ORM\Column(name="ammount", type="float")
     */
    private $ammount;

    /**
     * @ORM\ManyToOne(targetEntity="TransactionType")
     * @ORM\JoinColumn(name="transaction_type", referencedColumnName="id")
     */
    private $transactionType;

    /**
     * @ORM\ManyToOne(targetEntity="Notary", inversedBy="transactions")
     * @ORM\JoinColumn(name="notary", referencedColumnName="id")
     */
    private $notary;

    /**
     *  @ORM\ManyToOne(targetEntity="Person")
     *  @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;
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

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set service
     *
     * @param integer $service
     *
     * @return Transaction
     */
    public function setService($service) {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return int
     */
    public function getService() {
        return $this->service;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Transaction
     */
    public function setQty($qty) {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return int
     */
    public function getQty() {
        return $this->qty;
    }

    /**
     * Set ammount
     *
     * @param float $ammount
     *
     * @return Transaction
     */
    public function setAmmount($ammount) {
        $this->ammount = $ammount;

        return $this;
    }

    /**
     * Get ammount
     *
     * @return float
     */
    public function getAmmount() {
        return $this->ammount;
    }

    /**
     * Set transactionType
     *
     * @param integer $transactionType
     *
     * @return Transaction
     */
    public function setTransactionType($transactionType) {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return int
     */
    public function getTransactionType() {
        return $this->transactionType;
    }

    /**
     * Set notary
     *
     * @param integer $notary
     *
     * @return Transaction
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


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Transaction
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
     * @return Transaction
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Person $user
     *
     * @return Transaction
     */
    public function setUser(\AppBundle\Entity\Person $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Person
     */
    public function getUser()
    {
        return $this->user;
    }
}
