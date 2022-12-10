<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="abonnement")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\AbonnementRepository")
 */
class Abonnement
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;



    /***********************************************************************/


    /**
     * @ORM\ManyToOne(targetEntity="Adherent", inversedBy="abonnements")
     * @ORM\JoinColumn(name="adherent_id", referencedColumnName="id")
     */

    private $adherent;


    /**
     * @ORM\ManyToOne(targetEntity="Activite", inversedBy="abonnements")
     * @ORM\JoinColumn(name="activite_id", referencedColumnName="id")
     */

    private $activite;


    /***********************************************************************/


    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }


    /***********************************************************************/


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adherents = new \Doctrine\Common\Collections\ArrayCollection();
    }




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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Abonnement
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set adherent
     *
     * @param \Faculte\AdminBundle\Entity\Adherent $adherent
     *
     * @return Abonnement
     */
    public function setAdherent(\Faculte\AdminBundle\Entity\Adherent $adherent = null)
    {
        $this->adherent = $adherent;
    
        return $this;
    }

    /**
     * Get adherent
     *
     * @return \Faculte\AdminBundle\Entity\Adherent
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Set activite
     *
     * @param \Faculte\AdminBundle\Entity\Activite $activite
     *
     * @return Abonnement
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
