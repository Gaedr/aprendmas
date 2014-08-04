<?php

namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Proyecto\SecurityBundle\Entity\Actividad;
use Proyecto\SecurityBundle\Form\ActividadType;
use Proyecto\SecurityBundle\Form\ConceptosActividadType;
use Proyecto\SecurityBundle\Entity\ConceptosActividad;

class ActividadController extends Controller
{
    public function altaActividadAction(){
        $actividad = new Actividad();
        $form = $this->createForm(new ActividadType(), $actividad);
                        
        return $this->render('ProyectoSecurityBundle:Actividades:altaActividad.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function insertarAction(Request $request){
        $actividad = new Actividad();
        $form = $this->createForm(new ActividadType(), $actividad);
        
        if ( $request->isMethod( 'POST' ) ) { 
            $form->bind( $request ); 
            if ( $form->isValid( ) ) { 
                $em = $this->getDoctrine()->getManager();
                $em->persist($actividad);
                $em->flush();
                $response['success'] = true;
                $response['message'] = "La actividad se insertó correctamente"; 
            }else{ 
                $response['success'] = false;
                $response['message'] = 'No se pudo insertar la actividad'; 
            }
 
            return $this->redirect(
                $this->generateUrl('alta_actividad')
            );
        }                
        return $this->redirect(
            $this->generateUrl('alta_actividad')
        );
    }
    
    public function listarActividadesAction(){
        $listActividades = $this->getDoctrine()->getManager()->getRepository('ProyectoSecurityBundle:Actividad')->findAll();
        return $this->render('ProyectoSecurityBundle:Actividades:listarActividades.html.twig', array(
            'listaActividades' => $listActividades,
        ));
    }
    
    
    
    
    public function buscarAction($string){
        $listActividades = $this->getDoctrine()->getManager()->getRepository('ProyectoSecurityBundle:Actividad')->findBy(array('nombre' => '%'.$string.'%'));
        return $this->render('ProyectoSecurityBundle:Actividades:listarActividades.html.twig', array(
            'listaActividades' => $listActividades,
        ));
    }
    
    public function eliminarAction($idActividad){
        $em = $this->getDoctrine()->getManager();
        $actividades = $em->getRepository('ProyectoSecurityBundle:Actividad')->find($idActividad);
        
        if($actividades){
            $em->remove($actividades);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('alta_actividad')
            );
        }
        return $this->redirect(
            $this->generateUrl('alta_actividad')
        );
    }
    
    public function editarAction($idActividad, Request $request){
        $em = $this->getDoctrine()->getManager();
        $actividad = $em->getRepository('ProyectoSecurityBundle:Actividad')->findOneBy(array('id'=>$idActividad));
        $listaMultimedia = $em->getRepository('ProyectoSecurityBundle:ConceptosActividad')->findBy(array('actividad' => $idActividad));
        $conceptosActividad = new ConceptosActividad();
            
        $formConcepto = $this->createForm(new ConceptosActividadType(), $conceptosActividad);
        
        if ( $request->isMethod( 'POST' ) ) { 
            $formConcepto->bind( $request ); 
            if ( $formConcepto->isValid( ) ) { 
                $conceptosActividad.setActividad($actividad);
                $em->persist($conceptosActividad);
                $em->flush();
                
                return $this->redirect(
                    $this->generateUrl('editar_concepto', array('idActividad' => $actividad->getId()))
                );
            }
        }
        
        return $this->render('ProyectoSecurityBundle:Actividades:aniadirActividad.html.twig', array(
            'listaConceptos' => $actividad->getConceptosActividad(),
            'form' => $formConcepto->createView(),
            'actividad' => $actividad,
            'listaMultimedia' => $listaMultimedia
        ));
    }
    
    public function actualizarAction($idActividad, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ProyectoSecurityBundle:Actividad')->findOneBy(array('id'=>$idActividad));
        $actividad = $em->getRepository('ProyectoSecurityBundle:Actividad')->findOneBy(array('id'=>$idActividad));
        $form = $this->createForm(new ActividadType(), $actividad);
        
        $form->bind( $request ); 
        if ( $form->isValid( ) ) { 
            $em->persist($actividad);
            $em->flush();
        }
     
        return $this->redirect(
            $this->generateUrl('alta_actividad')
        );
    }
}



