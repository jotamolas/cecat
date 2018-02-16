<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notary
 *
 * @ORM\Table(name="notary")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotaryRepository")
 * 
 */
class Notary extends Person{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Registro", inversedBy="notarys")
     * @ORM\JoinColumn(name="registro", referencedColumnName="id")
     */
    private $registro;

    /**
     * @ORM\ManyToOne(targetEntity="NotaryType", inversedBy="notarys")
     * @ORM\JoinColumn(name="notary_type_id", referencedColumnName="id")
     */
    private $notaryTypeId;

    /**
     *  
     * One Customer has One Cart.
     * @ORM\OneToOne(targetEntity="Account", mappedBy="notary")
     */
    private $account;



    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="notary")
     */
    private $transactions;

    public function __construct() {
        parent::__construct();
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set registro
     *
     * @param string $registro
     *
     * @return Notary
     */
    public function setRegistro($registro) {
        $this->registro = $registro;

        return $this;
    }

    /**
     * Get registro
     *
     * @return string
     */
    public function getRegistro() {
        return $this->registro;
    }

    /**
     * Set notaryTypeId
     *
     * @param integer $notaryTypeId
     *
     * @return Notary
     */
    public function setNotaryTypeId($notaryTypeId) {
        $this->notaryTypeId = $notaryTypeId;

        return $this;
    }

    /**
     * Get notaryTypeId
     *
     * @return int
     */
    public function getNotaryTypeId() {
        return $this->notaryTypeId;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Notary
     */
    public function setAccount(\AppBundle\Entity\Account $account = null) {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Add transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     *
     * @return Notary
     */
    public function addTransaction(\AppBundle\Entity\Transaction $transaction) {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(\AppBundle\Entity\Transaction $transaction) {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions() {
        return $this->transactions;
    }


    public function __toString() {
        return "Notario: " . $this->getLastName() . ", " . $this->getFirstName();
    }

}
