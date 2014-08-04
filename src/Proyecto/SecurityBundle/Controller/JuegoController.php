<?php

namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class JuegoController extends Controller
{

    public function juegoAction($idActividad, $idAlumno){
        $em = $this->getDoctrine()->getManager();
        $actividad = $em->getRepository('ProyectoSecurityBundle:Actividad')->find($idActividad);
        
        $paresConcepto = $actividad->getConceptosActividad();
        $listaIzq = array();
        $listaDer = array();
        foreach ($paresConcepto as $parConcepto) {
            if($parConcepto->getMultimediaIzq() !== null ){
                $file1 = new UploadedFile($parConcepto->getMultimediaIzq()->getWebPath(), $parConcepto->getMultimediaIzq()->getPath());
            }
            if($parConcepto->getMultimediaDer() !== null ){
                $file2 = new UploadedFile($parConcepto->getMultimediaDer()->getWebPath(), $parConcepto->getMultimediaDer()->getPath());
            }
            $concepto1 = array(
                'concepto' => $parConcepto->getConceptoIzq(), 
                'solucion' => $parConcepto->getId(), 
                'tipo' =>  $parConcepto->getSelectIzq(),
                'mime' => $parConcepto->getMultimediaIzq() !== null ? $file1->getMimeType() : null,
                'multimedia' => $parConcepto->getMultimediaIzq() !== null ? $parConcepto->getMultimediaIzq() : null
                );
            array_push($listaIzq, $concepto1);
            
            $concepto2 = array(
                'concepto' => $parConcepto->getConceptoDer(), 
                'solucion' => $parConcepto->getId(), 
                'tipo' =>  $parConcepto->getSelectDer(),
                'mime' => $parConcepto->getMultimediaDer() !== null ? $file2->getMimeType() : null,
                'multimedia' => $parConcepto->getMultimediaDer() !== null ? $parConcepto->getMultimediaDer() : null
                );
            array_push($listaDer, $concepto2);
        }
        shuffle($listaIzq);
        shuffle($listaDer);
        $alumno = $em->getRepository('ProyectoSecurityBundle:Alumno')->find($idAlumno);
        return $this->render('ProyectoSecurityBundle:Juego:juego.html.twig', array(
            'alumno' => $alumno,
            'listaIzq' => $listaIzq,
            'listaDer' => $listaDer,
            'totalPreguntas' => count($listaDer)
        ));
    }
}