<?php

namespace Sensio\Bundle\GeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alumno
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sensio\Bundle\GeneratorBundle\Entity\AlumnoRepository")
 */
class Alumno
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
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=16)
     */
    private $usuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="especialista", type="integer")
     */
    private $especialista;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=200)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=100)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9)
     */
    private $telefono;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nacimiento", type="datetime")
     */
    private $nacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="fondo", type="string", length=100)
     */
    private $fondo;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo", type="string", length=100)
     */
    private $estilo;


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
     * Set usuario
     *
     * @param string $usuario
     * @return Alumno
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set especialista
     *
     * @param integer $especialista
     * @return Alumno
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
     * Set nombre
     *
     * @param string $nombre
     * @return Alumno
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
     * Set direccion
     *
     * @param string $direccion
     * @return Alumno
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Alumno
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set nacimiento
     *
     * @param \DateTime $nacimiento
     * @return Alumno
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;

        return $this;
    }

    /**
     * Get nacimiento
     *
     * @return \DateTime 
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    /**
     * Set fondo
     *
     * @param string $fondo
     * @return Alumno
     */
    public function setFondo($fondo)
    {
        $this->fondo = $fondo;

        return $this;
    }

    /**
     * Get fondo
     *
     * @return string 
     */
    public function getFondo()
    {
        return $this->fondo;
    }

    /**
     * Set estilo
     *
     * @param string $estilo
     * @return Alumno
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;

        return $this;
    }

    /**
     * Get estilo
     *
     * @return string 
     */
    public function getEstilo()
    {
        return $this->estilo;
    }
}
