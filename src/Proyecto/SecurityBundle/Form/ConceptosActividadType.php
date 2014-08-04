<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Proyecto\SecurityBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Proyecto\SecurityBundle\Form\ConceptosActividadType;
use Proyecto\SecurityBundle\Form\EventListener\AddMultimediaDerFieldSubscriber;


class ConceptosActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {         
        $factory = $builder->getFormFactory();
        $builder->add('conceptoIzq','genemu_jqueryselect2_entity',array(
            
            'label' => 'Concepto Izquierda',
            'class' => 'Proyecto\SecurityBundle\Entity\Conceptos',
            'property' => 'nombre'
            ));
        
        $builder->add('selectIzq','choice',array(
           'label'=> 'Selector Izquierda',
           'choices'=> array('0' => 'Nombre', '1' => 'Descripcion', '2'=>'Multimedia'),
           ));
        
        $builder->add('conceptoDer','entity',array(
            
            'label' => 'Concepto Derecha',
            'class' => 'Proyecto\SecurityBundle\Entity\Conceptos',
            'property' => 'nombre'
            ));
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $accion = $event->getData();
            $form = $event->getForm();
            
           if($accion !== null){
                    $form->add('multimediaIzq','entity',array(
                        'label'=>'Multimedia Izq',
                        'class'=>'Proyecto\SecurityBundle\Entity\Multimedia',
                        'property'=> 'nombre',
                    ));
            }
         });        
       
        $builder->add('selectDer','choice',array(
           'label'=> 'Selector Derecha',
           'choices'=> array('0' => 'Nombre', '1' => 'Descripcion', '2'=>'Multimedia'),
           ));
                        
        /*$factory = 'conceptoDer';//$builder->getFormFactory();
        $multimediaDerSubscriber = new AddMultimediaDerFieldSubscriber($factory);
        $builder->addEventSubscriber($multimediaDerSubscriber);*/
    
         $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $accion = $event->getData();
            $form = $event->getForm();

            if($accion !== null){
                    $form->add('multimediaDer','entity',array(
                        'label'=>'Multimedia Derecha',
                        'class'=>'Proyecto\SecurityBundle\Entity\Multimedia',
                        'property'=> 'nombre',
                    ));
                    /*$form->add($this->factory->createNamed('multimediaDer', 'entity', null, array(
                        'class'         => 'Proyecto\SecurityBundle\Entity\Multimedia',
                        'mapped'        => false,
                        'empty_value'   => 'Multimedia',
                        'query_builder' => function (EntityRepository $repository) {
                            $qb = $repository->createQueryBuilder('multimedia')
                                    ->where('multimedia.concepto=:'.$accion->getConceptoDer());
                            return $qb;
                        }
                    )));*/
               /* }else{
                    $form->add('multimediaDer','choice',array(
                        'label'=>'Multimedia Derecha',
                        'choices'=> array(null => 'No se necesita multimedia'),
                        'required' => false
                    ));
                }*/
            }
            
        });
        
    }

    public function getName() {
        return 'conceptos_actividad_form';
    }

//put your code here
}