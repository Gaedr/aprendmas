<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Proyecto\SecurityBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of AlumnoType
 *
 * @author JoseM
 */
class EspecialistaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('username', 'text',  array(
            'label' => "Usuario",
            'required' => true,
            'attr' => array(
                'placeholder' => 'Nombre de usuario'
            )                
        ))
        ->add('dni', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => "Escribe tu dni"
            )
        ))
        ->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Los campos de password deben coincidir',
            'required' => true,
            'first_options'  => array('label' => 'Contraseña', 'attr' => array('placeholder' => "Escriba su contraseña")),
            'second_options' => array('label' => 'Repite tu contraseña', 'attr' => array('placeholder' => "Vuelva a escribir su contraseña")),
        ))
        ->add('email', 'email', array(
            'required' => true,
            'attr' => array(
                'placeholder' => 'Escriba su email'
            )
        ));
        
    }

    public function getName() {
        return 'especialista_form';
    }

//put your code here
}