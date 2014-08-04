<?php

namespace Proyecto\SecurityBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Estadisticas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\EstadisticasRepository")
 */
class Estadisticas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\Alumno", mappedBy="id")
     * @ORM\JoinColumn(name="alumno", referencedColumnName="idAlumno")
     * @Assert\NotNull(message="El alumno no puede ser nulo")
     */
    private $alumno;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\Especialista", mappedBy="id")
     * @ORM\JoinColumn(name="especialista_id", referencedColumnName="idEspecialista")
     * @ORM\Column(name="especialista", type="integer")
     * @Assert\NotNull(message="El especialista no puede ser nulo")
     */
    private $especialista;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\Actividad", mappedBy="id")
     * @ORM\JoinColumn(name="actividad_id", referencedColumnName="idActividad")
     * @ORM\Column(name="actividad", type="integer")
     * @Assert\NotNull(message="La actividad no puede ser nula")
     */
    private $actividad;

    /**
     * @var integer
     *
     * @ORM\Column(name="aciertos", type="integer")
     */
    private $aciertos;

    /**
     * @var integer
     *
     * @ORM\Column(name="fallos", type="integer")
     */
    private $fallos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tiempo", type="time")
     */
    private $tiempo;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;


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
     * Set alumno
     *
     * @param integer $alumno
     * @return Estadisticas
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return integer 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set especialista
     *
     * @param integer $especialista
     * @return Estadisticas
     */
    public function setEspecialista($especialista)
    {
        $this->especialista = $especialista;

        return $this;
    }

    /**
     * Get especialista
     *
     * @return integer 
     */
    public function getEspecialista()
    {
        return $this->especialista;
    }

    /**
     * Set actividad
     *
     * @param integer $actividad
     * @return Estadisticas
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return integer 
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set aciertos
     *
     * @param integer $aciertos
     * @return Estadisticas
     */
    public function setAciertos($aciertos)
    {
        $this->aciertos = $aciertos;

        return $this;
    }

    /**
     * Get aciertos
     *
     * @return integer 
     */
    public function getAciertos()
    {
        return $this->aciertos;
    }

    /**
     * Set fallos
     *
     * @param integer $fallos
     * @return Estadisticas
     */
    public function setFallos($fallos)
    {
        $this->fallos = $fallos;

        return $this;
    }

    /**
     * Get fallos
     *
     * @return integer 
     */
    public function getFallos()
    {
        return $this->fallos;
    }

    /**
     * Set tiempo
     *
     * @param \DateTime $tiempo
     * @return Estadisticas
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return \DateTime 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Estadisticas
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }
}
