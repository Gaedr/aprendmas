<?php

namespace Proyecto\SecurityBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Alumno
 *
 * @ORM\Table(name="Alumno")
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\AlumnoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Alumno{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAlumno", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=16)
     * @Assert\NotNull()
     */
    private $usuario;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Especialista
     * @ORM\ManyToOne(targetEntity="Proyecto\SecurityBundle\Entity\Especialista", inversedBy="alumnos")
     * @ORM\JoinColumn(name="especialista",  referencedColumnName="idEspecialista", fieldName="Especialista", nullable=false)
     * @Assert\Valid()
     */
    private $especialista;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotNull()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9)
     */
    private $telefono;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nacimiento", type="date")
     */
    private $nacimiento;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $archivo;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo", type="string", length=100)
     */
    private $estilo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fondo", type="string", length=255)
     * @@Assert\Max(limit=255, message="La ruta es demasiado larga")
     */
    private $fondo;


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
     * @param \Proyecto\SecurityBundle\Entity\Especialista $especialista
     * @return Alumno
     */
    public function setEspecialista(\Proyecto\SecurityBundle\Entity\Especialista $especialista)
    {
        $this->especialista = $especialista;
        return $this;
    }

    /**
     * Get especialista
     *
     * @return \Proyecto\SecurityBundle\Entity\Especialista 
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
    
        //Código Modificado
    
    /**
     * 
     * @return type
     */
    public function getAbsolutePath(){
        return null === $this->fondo ? null : $this->getUploadRootDir().'/'.$this->fondo;
    }

    public function getWebPath() {
        return null === $this->fondo ? null : $this->getUploadDir().'/'.$this->fondo;
    }

    protected function getUploadRootDir(){
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir(){
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'imgUsuarios';
        
    }    

    private $temp;
    
    /**
     * Get archivo
     *
     * @return UploadedFile 
     */
    public function getArchivo(){
        return $this->archivo;
    }
    
    /**
     * Sets archivo.
     *
     * @param UploadedFile $archivo
     */
    public function setArchivo(UploadedFile $archivo = null){
        $this->archivo = $archivo;
        // check if we have an old image archivo
        if (isset($this->fondo)) {
            // store the old name to delete after the update
            $this->temp = $this->fondo;
            $this->fondo = null;
        } else {
            $this->fondo = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getArchivo()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->fondo = $filename.'.'.$this->getArchivo()->guessExtension();
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
        $this->getArchivo()->move($this->getUploadRootDir(), $this->fondo);
 
        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image fondo
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
    
    public function getFondo(){
        return $this->fondo;
    }

    public function __toString(){
        return $this->fondo;
    }
}
