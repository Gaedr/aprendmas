<?php

namespace Proyecto\SecurityBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
 
class AddMultimediaDerFieldSubscriber implements EventSubscriberInterface
{
    private $factory;
 
    public function __construct($factory)
    {
        $this->factory = $factory;
    }
 
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }
 
    private function addConceptoForm($form, $concepto)
    {
        $formOptions = array(
            'class'         => 'Proyecto\SecurityBundle\Entity\Multimedia',
            'empty_value'   => 'Multimedia',
            'label'         => 'Multimedia Derecha',
            'query_builder' => function (EntityRepository $repository) use ($concepto){
                $qb = $repository->createQueryBuilder('multimedia')
                        ->where('multimedia.concepto=:'.$concepto);
                        
                return $qb;
            }
        );
 
        $form->add($this->factory, 'entity', $formOptions);
        
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
        
        $accessor    = PropertyAccess::createPropertyAccessor();
        
        $c = $accessor->getValue($data, $this->factory);
  
        $concepto = ($c) ? $c->getConceptoDer()->getId() : null;
        $this->addConceptoForm($form, $concepto);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        $concepto = array_key_exists('multimediaDer', $data) ? $data['multimediaDer'] : null;
        $this->addConceptoForm($form, $concepto);
    }
}

