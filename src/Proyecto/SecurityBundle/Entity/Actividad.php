<?php

namespace Proyecto\SecurityBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\ActividadRepository")
 */
class Actividad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idActividad", type="integer")
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
     *
     * @var \Proyecto\SecurityBundle\Entity\ConceptosActividad
     * @ORM\OneToMany(targetEntity="\Proyecto\SecurityBundle\Entity\ConceptosActividad", mappedBy="actividad")
     * @Assert\Valid()
     */
    private $conceptosActividad;

    public function __construct() {
        $this->conceptosActividad = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Actividad
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
     * @return Actividad
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
     * Obtiene los conceptos con su tipo
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptosActividad(){
        return $this->conceptosActividad;
    }
 
    /**
     * 
     * @param \Doctrine\Common\Collections\Collection $caList
     * @return Actividad
     */
    public function setConceptosActividad(\Doctrine\Common\Collections\Collection $caList)
    {
        $this->conceptosActividad = $caList;
        foreach ($caList as $ca) {
            $ca->setActividad($this);
        }
    }
}
