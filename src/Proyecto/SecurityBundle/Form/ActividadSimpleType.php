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
use Proyecto\SecurityBundle\Entity\ConceptosActividad;


class ActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('descripcion', 'text', array(
            'required' => false,
            'label'  => 'Descripción',
            'attr' => array(
                'placeholder' => 'Escriba una descripción'
            )
        ));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $actividad = $event->getData();
            $form = $event->getForm();

            if (!$actividad || null === $actividad->getId()) {
                $form->add('nombre', 'text', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Escriba un nombre'
                    )
                ));
            }
        });
        //$builder->add('conceptosActividad', new ConceptosActividadType);
        $builder->add('conceptosActividad', 'collection', array(
            'type'      => new ConceptosActividadType(),
            'label'     => 'Conceptos',
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false,
            'options'   => array(
                'required'  => false
            )
        ));      
    }

    public function getName() {
        return 'actividad_form';
    }

//put your code here
}
