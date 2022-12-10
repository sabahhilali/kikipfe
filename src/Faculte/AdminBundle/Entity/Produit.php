<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="nomP", type="string", length=255)
     */
    private $nomP;

    /**
     * @var int
     *
     * @ORM\Column(name="qteP", type="integer")
     */
    private $qteP;

    /**
     * @var float
     *
     * @ORM\Column(name="prixP", type="float")
     */
    private $prixP;


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
        return dirname(__FILE__). '/../../../../web/files/produits/';
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
     * Set nomP
     *
     * @param string $nomP
     *
     * @return Produit
     */
    public function setNomP($nomP)
    {
        $this->nomP = $nomP;
    
        return $this;
    }

    /**
     * Get nomP
     *
     * @return string
     */
    public function getNomP()
    {
        return $this->nomP;
    }

    /**
     * Set qteP
     *
     * @param integer $qteP
     *
     * @return Produit
     */
    public function setQteP($qteP)
    {
        $this->qteP = $qteP;
    
        return $this;
    }

    /**
     * Get qteP
     *
     * @return integer
     */
    public function getQteP()
    {
        return $this->qteP;
    }

    /**
     * Set prixP
     *
     * @param float $prixP
     *
     * @return Produit
     */
    public function setPrixP($prixP)
    {
        $this->prixP = $prixP;
    
        return $this;
    }

    /**
     * Get prixP
     *
     * @return float
     */
    public function getPrixP()
    {
        return $this->prixP;
    }

    /**
     * Set pathFile
     *
     * @param string $pathFile
     *
     * @return Produit
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
}