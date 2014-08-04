<?php

namespace Proyecto\SecurityBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConceptosActividad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\ConceptosActividadRepository")
 */
class ConceptosActividad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idConceptosActividad", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Actividad
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Actividad", inversedBy="conceptosActividad")
     * @ORM\JoinColumn(name="actividad", referencedColumnName="idActividad")
     */
    private $actividad;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Conceptos  
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Conceptos", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="conceptoIzq",  referencedColumnName="idConceptos", fieldName="Concepto Izquierda", nullable=false)
     * @Assert\Valid()
     */
    private $conceptoIzq;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Conceptos 
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Conceptos", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="conceptoDer",  referencedColumnName="idConceptos", fieldName="Concepto Derecha", nullable=false)
     * @Assert\Valid()
     */
    private $conceptoDer;

    /**
     * @var integer
     *
     * @ORM\Column(name="seleccionIzq", type="integer")
     */
    private $selectIzq;

    /**
     * @var integer
     *
     * @ORM\Column(name="seleccionDer", type="integer")
     */
    private $selectDer;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Multimedia 
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Multimedia", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="multIzq",  referencedColumnName="idMultimedia", fieldName="Multimedia Izquierda", nullable=false)
     * @Assert\Valid()
     */
    private $multimediaIzq;

    /**
     * @var \Proyecto\SecurityBundle\Entity\Multimedia 
     * @ORM\ManyToOne(targetEntity="\Proyecto\SecurityBundle\Entity\Multimedia", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="multDer",  referencedColumnName="idMultimedia", fieldName="Multimedia Derecha", nullable=false)
     * @Assert\Valid()
     */
    private $multimediaDer;


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
     * Set actividad
     *
     * @param \Proyecto\SecurityBundle\Entity\Actividad $actividad
     * @return ConceptosActividad
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \Proyecto\SecurityBundle\Entity\Actividad 
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set conceptoIzq
     *
     * @param \Proyecto\SecurityBundle\Entity\Conceptos $conceptoIzq
     * @return ConceptosActividad
     */
    public function setConceptoIzq($conceptoIzq)
    {
        $this->conceptoIzq = $conceptoIzq;

        return $this;
    }

    /**
     * Get conceptoIzq
     *
     * @return \Proyecto\SecurityBundle\Entity\Conceptos 
     */
    public function getConceptoIzq()
    {
        return $this->conceptoIzq;
    }

    /**
     * Set conceptoDer
     *
     * @param \Proyecto\SecurityBundle\Entity\Conceptos  $conceptoDer
     * @return ConceptosActividad
     */
    public function setConceptoDer($conceptoDer)
    {
        $this->conceptoDer = $conceptoDer;

        return $this;
    }

    /**
     * Get conceptoDer
     *
     * @return \Proyecto\SecurityBundle\Entity\Conceptos  
     */
    public function getConceptoDer()
    {
        return $this->conceptoDer;
    }

    /**
     * Set selectIzq
     *
     * @param integer $selectIzq
     * @return ConceptosActividad
     */
    public function setSelectIzq($selectIzq)
    {
        $this->selectIzq = $selectIzq;

        return $this;
    }

    /**
     * Get selectIzq
     *
     * @return integer 
     */
    public function getSelectIzq()
    {
        return $this->selectIzq;
    }

    /**
     * Set selectDer
     *
     * @param integer $selectDer
     * @return ConceptosActividad
     */
    public function setSelectDer($selectDer)
    {
        $this->selectDer = $selectDer;

        return $this;
    }

    /**
     * Get selectDer
     *
     * @return integer 
     */
    public function getSelectDer()
    {
        return $this->selectDer;
    }

    /**
     * Set multimediaIzq
     *
     * @param \Proyecto\SecurityBundle\Entity\Multimedia  $multimediaIzq
     * @return ConceptosActividad
     */
    public function setMultimediaIzq($multimediaIzq)
    {
        $this->multimediaIzq = $multimediaIzq;

        return $this;
    }

    /**
     * Get multimediaIzq
     *
     * @return \Proyecto\SecurityBundle\Entity\Multimedia 
     */
    public function getMultimediaIzq()
    {
        return $this->multimediaIzq;
    }

    /**
     * Set multimediaDer
     *
     * @param \Proyecto\SecurityBundle\Entity\Multimedia $multimediaDer
     * @return ConceptosActividad
     */
    public function setMultimediaDer($multimediaDer)
    {
        $this->multimediaDer = $multimediaDer;

        return $this;
    }

    /**
     * Get multimediaDer
     *
     * @return \Proyecto\SecurityBundle\Entity\Multimedia 
     */
    public function getMultimediaDer()
    {
        return $this->multimediaDer;
    }
}
