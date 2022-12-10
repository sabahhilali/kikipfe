<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\ActiviteRepository")
 */
class Activite
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
     * @ORM\Column(name="nomA", type="string", length=255)
     */
    private $nomA;


    /**
     * @var string
     *
     * @ORM\Column(name="descriptionA", type="text", length=255)
     */
    private $descriptionA;




    /**
     * @var string
     *
     * @ORM\Column(name="pathFile", type="string", length=255, nullable=true)
     */
    private $pathFile;


    public function getFullPathFilePath() {
        return null === $this->pathFile ? null : $this->getUploadPathFileRootDir(). $this->pathFile;
    }

    public function getUploadPathFileRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadPathFileRootDir()."/".$this->getId()."/";
    }

    public function getTmpUploadPathFileRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return dirname(__FILE__). '/../../../../web/files/activites/';
    }

    public function getExtensionPathFile() {

        $name = strtr($this->pathFile->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $name = preg_replace('/([^.a-z0-9]+)/i', '-', $name);

        $ext = strtolower(substr($name, strrpos($name, '.'))); // extension du fichier
        return  $ext;
    }

    public function uploadPathFile() {

        // the file property can be empty if the field is not required
        if (null === $this->pathFile) {
            return;
        }

        $name = strtr($this->pathFile->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $name = preg_replace('/([^.a-z0-9]+)/i', '-', $name);

        if(!$this->getId()){
            $this->pathFile->move($this->getTmpUploadPathFileRootDir(), $name);
        }else{
            $this->pathFile->move($this->getUploadPathFileRootDir(), $name);
        }

        $this->setPathFile($name);

    }


    public function movePathFile()
    {
        if (null === $this->pathFile) {
            return;
        }

        if(!is_dir($this->getUploadPathFileRootDir())){
            mkdir($this->getUploadPathFileRootDir());
        }
        copy($this->getTmpUploadPathFileRootDir().$this->pathFile, $this->getFullPathFilePath());
        unlink($this->getTmpUploadPathFileRootDir().$this->pathFile);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removePathFile()
    {
        if(file_exists($this->getFullPathFilePath())){
            unlink($this->getFullPathFilePath());
            //rmdir($this->getUploadPathFileRootDir());
        }

    }





    /***************************************************************************/


    /**
     * @ORM\OneToMany(targetEntity="Abonnement", mappedBy="activite")
     *
     */
    private $abonnements;

    /**
     * @ORM\OneToMany(targetEntity="Tarif", mappedBy="activite")
     *
     */
    private $tarifs;


    /***************************************************************************/



    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNomA();
    }




    /***************************************************************************/

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->abonnements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tarifs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nomA
     *
     * @param string $nomA
     *
     * @return Activite
     */
    public function setNomA($nomA)
    {
        $this->nomA = $nomA;
    
        return $this;
    }

    /**
     * Get nomA
     *
     * @return string
     */
    public function getNomA()
    {
        return $this->nomA;
    }

    /**
     * Set descriptionA
     *
     * @param string $descriptionA
     *
     * @return Activite
     */
    public function setDescriptionA($descriptionA)
    {
        $this->descriptionA = $descriptionA;
    
        return $this;
    }

    /**
     * Get descriptionA
     *
     * @return string
     */
    public function getDescriptionA()
    {
        return $this->descriptionA;
    }

    /**
     * Set pathFile
     *
     * @param string $pathFile
     *
     * @return Activite
     */
    public function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;
    
        return $this;
    }

    /**
     * Get pathFile
     *
     * @return string
     */
    public function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * Add abonnement
     *
     * @param \Faculte\AdminBundle\Entity\Abonnement $abonnement
     *
     * @return Activite
     */
    public function addAbonnement(\Faculte\AdminBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnements[] = $abonnement;
    
        return $this;
    }

    /**
     * Remove abonnement
     *
     * @param \Faculte\AdminBundle\Entity\Abonnement $abonnement
     */
    public function removeAbonnement(\Faculte\AdminBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnements->removeElement($abonnement);
    }

    /**
     * Get abonnements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbonnements()
    {
        return $this->abonnements;
    }

    /**
     * Add tarif
     *
     * @param \Faculte\AdminBundle\Entity\Tarif $tarif
     *
     * @return Activite
     */
    public function addTarif(\Faculte\AdminBundle\Entity\Tarif $tarif)
    {
        $this->tarifs[] = $tarif;
    
        return $this;
    }

    /**
     * Remove tarif
     *
     * @param \Faculte\AdminBundle\Entity\Tarif $tarif
     */
    public function removeTarif(\Faculte\AdminBundle\Entity\Tarif $tarif)
    {
        $this->tarifs->removeElement($tarif);
    }

    /**
     * Get tarifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTarifs()
    {
        return $this->tarifs;
    }
}
