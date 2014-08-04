<?php

namespace Proyecto\SecurityBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\ConceptosRepository")
 */
class Conceptos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idConceptos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;
    
    /**
     * @ORM\OneToMany(targetEntity="\Proyecto\SecurityBundle\Entity\Multimedia", mappedBy="concepto", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $multimedias;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->multimedias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Conceptos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Conceptos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    /**
     * Obtiene los archivos multimedia
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMultimedias(){
        return $this->multimedias;
    }
 
    /**
     * 
     * @param \Doctrine\Common\Collections\Collection $multimedias
     * @return Conceptos
     */
    public function setMultimedias(\Doctrine\Common\Collections\Collection $multimedias)
    {
        $this->multimedias = $multimedias;
        foreach ($multimedias as $multimedia) {
            $multimedia->setConcepto($this);
        }
    }
}
