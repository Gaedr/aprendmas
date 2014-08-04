<?php

namespace Proyecto\SecurityBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityRepository;
 
class AddMultimediaIzqFieldSubscriber implements EventSubscriberInterface
{
    private $factory;
 
    public function __construct(FormFactoryInterface $factory)
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
        $form->add($this->factory->createNamed('concepto', 'entity', $concepto, array(
            'class'         => 'SecurityBundle:Conceptos',
            'mapped'        => false,
            'empty_value'   => 'Concepto',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('conceptos');
 
                return $qb;
            }
        )));
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
  
        $concepto = ($data->conceptoDer) ? $data->conceptoDer : null;
        $this->addConceptoForm($form, $concepto);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        $concepto = array_key_exists('conceptoDer', $data) ? $data['conceptoDer'] : null;
        $this->addConceptoForm($form, $concepto);
    }
}

