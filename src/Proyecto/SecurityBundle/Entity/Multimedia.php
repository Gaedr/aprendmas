<?php

namespace Proyecto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Multimedia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\MultimediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Multimedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMultimedia", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\File(maxSize="60000000")
     */
    private $archivo;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Conceptos
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Conceptos", inversedBy="multimedias")
     * @ORM\JoinColumn(name="concepto", referencedColumnName="idConceptos", fieldName="Concepto", nullable=false)
     * @Assert\Valid()
     */
    private $concepto;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     * @@Assert\Max(limit=255, message="La ruta es demasiado larga")
     */
    private $path;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @@Assert\Max(limit=255, message="La ruta es demasiado larga")
     */
    private $nombre;
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Get archivo
     *
     * @return UploadedFile 
     */
    public function getArchivo(){
        return $this->archivo;
    }
    
    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre(){
        return $this->nombre;
    }
    
    /**
     * Set nombre
     *
     * @return Multimedia 
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Set concepto
     *
     * @param \Proyecto\SecurityBundle\Entity\Conceptos $concepto
     * @return Multimedia
     */
    public function setConcepto(\Proyecto\SecurityBundle\Entity\Conceptos $concepto){
        $this->concepto = $concepto;
        return $this;
    }

    /**
     * Get concepto
     *
     * @return \Proyecto\SecurityBundle\Entity\Conceptos 
     */
    public function getConcepto(){
        return $this->concepto;
    }
    
    //Código Modificado
    
    /**
     * 
     * @return type
     */
    public function getAbsolutePath(){
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir(){
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir(){
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads';
        
    }    

    private $temp;

    /**
     * Sets archivo.
     *
     * @param UploadedFile $archivo
     */
    public function setArchivo(UploadedFile $archivo = null){
        $this->archivo = $archivo;
        // check if we have an old image archivo
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getArchivo()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getArchivo()->getClientOriginalExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if (null === $this->getArchivo()) {
            return;
        }

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getArchivo()->move($this->getUploadRootDir(), $this->path);
 
        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->archivo = null;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove(){
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if ($archivo = $this->getAbsolutePath()) {
            unlink($archivo);
        }
    }
    
    public function getPath(){
        return $this->path;
    }

    public function __toString(){
        return $this->path;
    }
    
    
}
