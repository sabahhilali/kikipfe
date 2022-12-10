<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarif
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="tarif")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\TarifRepository")
 */
class Tarif
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
     * @var string
     *
     * @ORM\Column(name="prixT", type="string")
     */
    private $prixT;

/********************************************************/

    /**
     * @ORM\ManyToOne(targetEntity="Activite", inversedBy="tarifs")
     * @ORM\JoinColumn(name="activite_id", referencedColumnName="id")
     */

    private $activite;



    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getprixT();
    }

    /********************************************************/



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prixT
     *
     * @param string $prixT
     *
     * @return Tarif
     */
    public function setPrixT($prixT)
    {
        $this->prixT = $prixT;
    
        return $this;
    }

    /**
     * Get prixT
     *
     * @return string
     */
    public function getPrixT()
    {
        return $this->prixT;
    }

    /**
     * Set activite
     *
     * @param \Faculte\AdminBundle\Entity\Activite $activite
     *
     * @return Tarif
     */
    public function setActivite(\Faculte\AdminBundle\Entity\Activite $activite = null)
    {
        $this->activite = $activite;
    
        return $this;
    }

    /**
     * Get activite
     *
     * @return \Faculte\AdminBundle\Entity\Activite
     */
    public function getActivite()
    {
        return $this->activite;
    }
}
