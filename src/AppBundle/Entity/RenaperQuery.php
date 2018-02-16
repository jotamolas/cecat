<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RenaperQuer
 *
 * @ORM\Table(name="renaper_query")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RenaperQueryRepository")
 */
class RenaperQuery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumn(name="transaction", referencedColumnName="id")
     */
    private $transaction;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf", type="string", length=255)
     */
    private $pdf;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set pdf
     *
     * @param string $pdf
     *
     * @return RenaperQuer
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     *
     * @return RenaperQuery
     */
    public function setTransaction(\AppBundle\Entity\Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \AppBundle\Entity\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return RenaperQuery
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
