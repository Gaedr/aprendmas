<?php

namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Proyecto\SecurityBundle\Form\ConceptoType;
use Proyecto\SecurityBundle\Entity\Conceptos;
use Proyecto\SecurityBundle\Entity\Multimedia;
use Proyecto\SecurityBundle\Form\MultimediaType;

class ConceptosController extends Controller
{
    public function altaConceptoAction(){
        $concepto = new Conceptos();
        $form = $this->createForm(new ConceptoType(), $concepto);
                        
        return $this->render('ProyectoSecurityBundle:Conceptos:altaConcepto.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function insertarAction(Request $request){
        $concepto = new Conceptos();
        $form = $this->createForm(new ConceptoType(), $concepto);
        
        if ( $request->isMethod( 'POST' ) ) { 
            $form->bind( $request ); 
            if ( $form->isValid( ) ) { 
                $em = $this->getDoctrine()->getManager();
                $em->persist($concepto);
                $em->flush();
                $response['success'] = true;
                $response['message'] = "El concepto se insertó correctamente"; 
            }else{ 
                $response['success'] = false;
                $response['message'] = 'No se pudo insertar el concepto'; 
            }
 
            return $this->redirect(
                $this->generateUrl('alta_concepto')
            );
        }                
        return $this->redirect(
            $this->generateUrl('alta_concepto')
        );
    }
    
    public function listarConceptosAction(){
        $listConceptos = $this->getDoctrine()->getManager()->getRepository('ProyectoSecurityBundle:Conceptos')->findAll();
        return $this->render('ProyectoSecurityBundle:Conceptos:listarConceptos.html.twig', array(
            'listaConceptos' => $listConceptos,
        ));
    }
    
    public function buscarAction($string){
        $listConceptos = $this->getDoctrine()->getManager()->getRepository('ProyectoSecurityBundle:Conceptos')->findBy(array('nombre' => '%'.$string.'%'));
        return $this->render('ProyectoSecurityBundle:Conceptos:listarConceptos.html.twig', array(
            'listaConceptos' => $listConceptos,
        ));
    }
    
    public function eliminarAction($idConcepto){
        $em = $this->getDoctrine()->getManager();
        $concepto = $em->getRepository('ProyectoSecurityBundle:Conceptos')->findOneBy(array('id'=> $idConcepto));
        
        if($concepto){
            $em->remove($concepto);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('alta_concepto')
            );
        }
        return $this->redirect(
            $this->generateUrl('alta_concepto')
        );
    }
    
    public function editarAction($idConcepto){
        $em = $this->getDoctrine()->getManager();
        $concepto = $em->getRepository('ProyectoSecurityBundle:Conceptos')->find($idConcepto);
        
        $formConcepto = $this->createForm(new ConceptoType(), $concepto);
        
        return $this->render('ProyectoSecurityBundle:Conceptos:editarConcepto.html.twig', array(
            'form' => $formConcepto->createView(),
            'idConcepto' => $idConcepto,
        ));
    }
    
    public function actualizarAction($idConcepto, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ProyectoSecurityBundle:Conceptos')->findOneBy(array('id'=>$idConcepto));
        $concepto = $em->getRepository('ProyectoSecurityBundle:Conceptos')->findOneBy(array('id'=>$idConcepto));
        $form = $this->createForm(new ConceptoType(), $concepto);
        
        $form->bind( $request ); 
        if ( $form->isValid( ) ) { 
            $em->persist($concepto);
            $em->flush();
        }
        return $this->redirect(
            $this->generateUrl('alta_concepto')
        );
    }
}

