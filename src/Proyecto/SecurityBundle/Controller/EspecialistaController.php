<?php


namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Proyecto\SecurityBundle\Form\EspecialistaType;
use Proyecto\SecurityBundle\Entity\Especialista;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class EspecialistaController extends Controller
{
    public function altaAction()
    {
        $especialista = new Especialista();
        $form = $this->createForm(new EspecialistaType(), $especialista);
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($especialista);
                $em->flush();

                return $this->redirect($this->generateUrl('login_especialista'));
            }
        }
        
        return $this->render('ProyectoSecurityBundle:Especialista:altaEspecialista.html.twig', array(
        'especialista_form' => $form->createView(),
        ));
    }
    
    public function crearAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $especialista = new Especialista();
        $form = $this->createForm(new EspecialistaType, $especialista);
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            $encoderFactory = $this->get('security.encoder_factory');
            $encoder = $encoderFactory->getEncoder($especialista);
            $password = $encoder->encodePassword($especialista->getPassword(), $especialista->getSalt());
            $especialista->setPassword($password);
            
            $em->persist($especialista);
            $em->flush();
            
            return $this->redirect($this->generateUrl('especialista_creado'));
        }
        
        return $this->render('ProyectoSecurityBundle:Especialista:altaEspecialista.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    
    public function perfilAction(){
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }else{
            $em = $this->getDoctrine()->getManager();
            $usuario = $this->get('security.context')->getToken()->getUser(); 
            $listaAlumnos = $usuario->getAlumnos();
            return $this->render('ProyectoSecurityBundle:Especialista:perfil.html.twig', array(
                'listaAlumnos' => $listaAlumnos
            ));
        }
    }
    
    public function bienvenidaAction(){
        return $this->render('ProyectoSecurityBundle:Especialista:creado.html.twig');
    }
}
