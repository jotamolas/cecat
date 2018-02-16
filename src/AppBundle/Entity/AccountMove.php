<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountMove
 *
 * @ORM\Table(name="account_move")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountMoveRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AccountMove {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="moves")
     * @ORM\JoinColumn(name="account", referencedColumnName="id")
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="credit", type="float")
     */
    private $credit;

    /**
     * @var float
     *
     * @ORM\Column(name="debit", type="float")
     */
    private $debit;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at",type="datetime")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     * 
     * @ORM\Column(name="updated_at",type="datetime", nullable = true)
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumn(name="transaction", referencedColumnName="id")
     */
    private $transaction;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set account
     *
     * @param integer $account
     *
     * @return AccountMove
     */
    public function setAccount($account) {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return int
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AccountMove
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
     * Set credit
     *
     * @param float $credit
     *
     * @return AccountMove
     */
    public function setCredit($credit) {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return float
     */
    public function getCredit() {
        return $this->credit;
    }

    /**
     * Set transaction
     *
     * @param integer $transaction
     *
     * @return AccountMove
     */
    public function setTransaction($transaction) {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return int
     */
    public function getTransaction() {
        return $this->transaction;
    }

    /**
     * Set debit
     *
     * @param float $debit
     *
     * @return AccountMove
     */
    public function setDebit($debit) {
        $this->debit = $debit;

        return $this;
    }

    /**
     * Get debit
     *
     * @return float
     */
    public function getDebit() {
        return $this->debit;
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
        $msg = "Id: " . $this->getId() . " | ";
        if ($this->getCredit()) {
            $msg .= " Credit: " . $this->getCredit() . " | ";
        } else {
            $msg .= " Debit: " . $this->getDebit() . " | ";
        }
        return $msg;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AccountMove
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
     * @return AccountMove
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
