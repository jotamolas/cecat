<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Registro
 * @UniqueEntity("number")
 * @ORM\Table(name="registro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistroRepository")
 */
class Registro {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     *
     * @var int 
     * @ORM\Column(name="number", type="integer", unique=true)
     */
    private $number;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="Notary", mappedBy="registro")
     */
    private $notarys;

    public function __construct() {
        $this->notarys = new ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return Registro
     */
    public function setDescription() {
        
        
        $this->description = "Registro ".$this->getNumber();

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
     * Set address
     *
     * @param string $address
     *
     * @return Registro
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Registro
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Registro
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }


    /**
     * Add notary
     *
     * @param \AppBundle\Entity\Notary $notary
     *
     * @return Registro
     */
    public function addNotary(\AppBundle\Entity\Notary $notary)
    {
        $this->notarys[] = $notary;

        return $this;
    }

    /**
     * Remove notary
     *
     * @param \AppBundle\Entity\Notary $notary
     */
    public function removeNotary(\AppBundle\Entity\Notary $notary)
    {
        $this->notarys->removeElement($notary);
    }

    /**
     * Get notarys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotarys()
    {
        return $this->notarys;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Registro
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
}
