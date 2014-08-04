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

/**
 * Description of AlumnoType
 *
 * @author JoseM
 */
class AlumnoType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('usuario', 'text', array(
            'label' => "Usuario",
            'attr'  => array(
                'placeholder' => 'Escriba el nombre de usuario'
            )
        ))
        ->add('nombre', 'text', array(
            'label' => "Nombre completo",
            'attr'  => array(
                'placeholder' => 'Escriba el nombre completo'
            )
        ))
        ->add('telefono', null,array(
            'required' => false,
            'label' => "Teléfono",
            'attr'  => array(
                'placeholder' => 'Escriba el teléfono de contacto'
            )
        ))
        ->add('nacimiento', 'birthday', array(
            'required' => false,
            'format' => 'dd - MMMM - yyyy',
            'years' => range(1930, 2014),
        ))
        ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $alumno = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if ($alumno->getWebPath() == '' || null === $alumno->getWebPath()) {
                $form->add('archivo', 'file', array(
                    'label' => 'Archivo: No ha seleccionado ninguna imágen',
                    'required' => false,
                ));
            }else{
                $form->add('archivo', 'file', array(
                    'label' => 'Archivo: '.$alumno->getWebPath(),
                    'required' => false,
                    
                ));
            }
        });
        
    }

    public function getName() {
        return 'alumno_form';
    }

//put your code here
}
