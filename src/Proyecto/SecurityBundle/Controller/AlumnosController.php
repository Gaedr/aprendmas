<?php

namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Proyecto\SecurityBundle\Form\AlumnoType;
use Proyecto\SecurityBundle\Entity\Alumno;


class AlumnosController extends Controller
{
    public function crearAlumnoAction(Request $request){
        $alumno = new Alumno();
        $form = $this->createForm(new AlumnoType(), $alumno);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $especialista = $this->get('security.context')->getToken()->getUser();
                $alumno->setEspecialista($especialista);
                $em->persist($alumno);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                return $this->redirect(
                    $this->generateUrl('perfil')
                );
            }            
            return $this->render('ProyectoSecurityBundle:Alumnos:altaAlumno.html.twig', array(
                'form' => $form->createView()
            ));
        }
        
        return $this->render('ProyectoSecurityBundle:Alumnos:altaAlumno.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function loginAlumnoAction($error = null){
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('ProyectoSecurityBundle:Alumnos:loginAlumno.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    /*public function loguearAlumnoAction($usuario){
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->findBy(array('usuario'=>$usuario));
        if (!$alumno) {
            throw $this->createNotFoundException('El usuario no existe');
        }
    }*/
    
    public function eliminarAction($idAlumno){
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->findOneBy(array('id'=> $idAlumno));
        
        if($alumno){
            $em->remove($alumno);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('perfil')
            );
        }
        return $this->redirect(
            $this->generateUrl('perfil')
        );
    }
    
    public function editarAction($idAlumno){
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->find($idAlumno);
        
        $formAlumno = $this->createForm(new AlumnoType(), $alumno);
        
        return $this->render('ProyectoSecurityBundle:Alumnos:editarAlumno.html.twig', array(
            'form' => $formAlumno->createView(),
            'idAlumno' => $idAlumno,
        ));
    }
    
    public function actualizarAction($idAlumno, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ProyectoSecurityBundle:Alumno')->findOneBy(array('id'=>$idAlumno));
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->findOneBy(array('id'=>$idAlumno));
        $form = $this->createForm(new AlumnoType(), $alumno);
        
        $form->bind( $request ); 
        if ( $form->isValid( ) ) { 
            $em->persist($alumno);
            $em->flush();
        }
        return $this->redirect(
            $this->generateUrl('perfil')
        );
    }
    
    public function seleccionarActividadAction(){
        $request = Request::createFromGlobals();
        
        $nombreAlumno = $request->request->get('username');
        if($nombreAlumno == null){
            $nombreAlumno =  $request->get('username');
        }
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->findOneBy(array('usuario'=>$nombreAlumno));
        
        if (!$alumno) {
            return $this->redirect($this->generateUrl('login_alumno', array('error' => 'El alumno '.$nombreAlumno.' no existe'), false));
        }else{
            $listActividades = $this->getDoctrine()->getManager()->getRepository('ProyectoSecurityBundle:Actividad')->findAll();
            return $this->render('ProyectoSecurityBundle:Alumnos:seleccionarActividad.html.twig', array(
                'listaActividades' => $listActividades,
                'alumno' => $alumno
            ));
        }
    }
    
}