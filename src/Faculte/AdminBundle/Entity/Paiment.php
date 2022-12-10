<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiment
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="paiment")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\PaimentRepository")
 */
class Paiment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /*******************************************************************/

    /**
     * @ORM\ManyToMany(targetEntity="Adherent" , mappedBy="paiments",cascade={"remove"})
     */
    private $adherent;


    /**
     * @ORM\OneToMany(targetEntity="Activite", mappedBy="paiment")
     *
     */
    private $activites;
    /*******************************************************************/



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adherent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activites = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add adherent
     *
     * @param \Faculte\AdminBundle\Entity\Adherent $adherent
     *
     * @return Paiment
     */
    public function addAdherent(\Faculte\AdminBundle\Entity\Adherent $adherent)
    {
        $this->adherent[] = $adherent;
    
        return $this;
    }

    /**
     * Remove adherent
     *
     * @param \Faculte\AdminBundle\Entity\Adherent $adherent
     */
    public function removeAdherent(\Faculte\AdminBundle\Entity\Adherent $adherent)
    {
        $this->adherent->removeElement($adherent);
    }

    /**
     * Get adherent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Add activite
     *
     * @param \Faculte\AdminBundle\Entity\Activite $activite
     *
     * @return Paiment
     */
    public function addActivite(\Faculte\AdminBundle\Entity\Activite $activite)
    {
        $this->activites[] = $activite;
    
        return $this;
    }

    /**
     * Remove activite
     *
     * @param \Faculte\AdminBundle\Entity\Activite $activite
     */
    public function removeActivite(\Faculte\AdminBundle\Entity\Activite $activite)
    {
        $this->activites->removeElement($activite);
    }

    /**
     * Get activites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivites()
    {
        return $this->activites;
    }
}
