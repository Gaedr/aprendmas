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
class ConceptoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('nombre', 'text', array(
                    'attr' => array(
                        'placeholder' => 'Nombre del concepto'
                    )
                ))
                ->add('descripcion', 'text', array(
                    'required' => false,
                    'label' => 'Descripción',
                    'attr' => array(
                        'placeholder' => 'Descripción del concepto'
                    )
                )); 
    }

    public function getName() {
        return 'concepto_form';
    }

//put your code here
}
