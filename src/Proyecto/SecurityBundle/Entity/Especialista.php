<?php

namespace Proyecto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Especialista
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\EspecialistaRepository")
 */
class Especialista implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEspecialista", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=9, unique=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="salt", type="string", length=100)
     */
    private $salt;
    
    /**
     * 
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\Alumno", mappedBy="especialista", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $alumnos;
    
    /**
     * Obtiene el alumno
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlumnos(){
        return $this->alumnos;
    }
 
    /**
     * 
     * @param \Doctrine\Common\Collections\Collection $alumnos
     * @return Especialista
     */
    public function setAlumnos(\Doctrine\Common\Collections\Collection $alumnos)
    {
        $this->alumnos = $alumnos;
        foreach ($alumnos as $alumno) {
            $alumno->setEspecialista($this);
        }
    }

    
    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return Especialista
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Especialista
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Especialista
     */
    public function setPassword($password){        
        //$this->password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        $this->password = $password;
        return $this;
    }

    /**
     * Set correo
     *
     * @param string $email
     * @return Especialista
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt
        ));
    }
    
    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt
        ) = unserialize($serialized);
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        return array('ROLE_ADMIN');
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isEnabled() {
        return $this->isActive;
    }
    
    /**
     * equals.
     *
     * @param AdvancedUserInterface $account
     * @return bool
     */
    public function equals(AdvancedUserInterface $account)
    {
        if ($account->getUsername() != $this->getUsername) {
            return false;
        }
        return true;
    }
    
    public function __toString()
    {
        return $this->getUsername();
    }

}
