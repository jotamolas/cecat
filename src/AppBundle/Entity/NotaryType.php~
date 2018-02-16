<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use     Doctrine\Common\Collections\ArrayCollection;
/**
 * NotaryType
 *
 * @ORM\Table(name="notary_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotaryTypeRepository")
 */
class NotaryType {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Notary", mappedBy="notaryTypeId")
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
     * @return NotaryType
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
     * Add notary
     *
     * @param \AppBundle\Entity\Notary $notary
     *
     * @return NotaryType
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
}
