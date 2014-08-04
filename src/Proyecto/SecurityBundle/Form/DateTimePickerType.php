<?php

namespace Proyecto\SecurityBundle\Form;
 
use Symfony\Component\Form\AbstractType;
 
class DateTimePickerType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy HH:mm',
            'attr' => array(
                'autocomplete' => 'off',
                'class' => 'datetime_picker',
            ),
        );
    }
 
    public function getParent()
    {
        return 'date';
    }
 
    public function getName()
    {
        return 'datetime_picker';
    }
}