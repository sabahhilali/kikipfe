<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coach
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="coach")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\CoachRepository")
 */
class Coach
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
     * @ORM\Column(name="cin", type="string", length=255)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \string
     *
     * @ORM\Column(name="dateNaiss", type="string")
     */
    private $dateNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaiss", type="string", length=255)
     */
    private $lieuNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adrss", type="string", length=255)
     */
    private $adrss;


    /**
     * @var string
     *
     * @ORM\Column(name="salaire", type="string", length=255)
     */
    private $salaire;




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
        return dirname(__FILE__). '/../../../../web/files/coachs/';
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



    /***********************************************/
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;




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
     * Set cin
     *
     * @param string $cin
     *
     * @return Coach
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    
        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Coach
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Coach
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaiss
     *
     * @param string $dateNaiss
     *
     * @return Coach
     */
    public function setDateNaiss($dateNaiss)
    {
        $this->dateNaiss = $dateNaiss;
    
        return $this;
    }

    /**
     * Get dateNaiss
     *
     * @return string
     */
    public function getDateNaiss()
    {
        return $this->dateNaiss;
    }

    /**
     * Set lieuNaiss
     *
     * @param string $lieuNaiss
     *
     * @return Coach
     */
    public function setLieuNaiss($lieuNaiss)
    {
        $this->lieuNaiss = $lieuNaiss;
    
        return $this;
    }

    /**
     * Get lieuNaiss
     *
     * @return string
     */
    public function getLieuNaiss()
    {
        return $this->lieuNaiss;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Coach
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Coach
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adrss
     *
     * @param string $adrss
     *
     * @return Coach
     */
    public function setAdrss($adrss)
    {
        $this->adrss = $adrss;
    
        return $this;
    }

    /**
     * Get adrss
     *
     * @return string
     */
    public function getAdrss()
    {
        return $this->adrss;
    }

    /**
     * Set salaire
     *
     * @param string $salaire
     *
     * @return Coach
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    
        return $this;
    }

    /**
     * Get salaire
     *
     * @return string
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set pathFile
     *
     * @param string $pathFile
     *
     * @return Coach
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
     * Set user
     *
     * @param \Faculte\AdminBundle\Entity\User $user
     *
     * @return Coach
     */
    public function setUser(\Faculte\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Faculte\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}