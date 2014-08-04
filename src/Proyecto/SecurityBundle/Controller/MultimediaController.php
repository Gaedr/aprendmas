<?php


namespace Proyecto\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Proyecto\SecurityBundle\Form\MultimediaType;
use Proyecto\SecurityBundle\Entity\Multimedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author gaedr
 */
class MultimediaController extends Controller
{
    public function aniadirAction($idConcepto){
        $multimedia = new Multimedia();
        $form = $this->createForm(new MultimediaType(), $multimedia);  
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $multimedia->setConcepto($em->getRepository("ProyectoSecurityBundle:Conceptos")->find($idConcepto));
                $em->persist($multimedia);
                $em->flush();
                return $this->redirect(
                        $this->generateUrl('editar_concepto', array('idConcepto' => $idConcepto))
                );
            }
        }
        return $this->render('ProyectoSecurityBundle:Multimedia:aniadirArchivo.html.twig',array(
            'idConcepto' =>$idConcepto,
            'formMultimedia' => $form->createView()
        ));
    }
    
    public function listarAction($idConcepto){
        $em = $this->getDoctrine()->getManager();
        $concepto = $em->getRepository("ProyectoSecurityBundle:Conceptos")->find($idConcepto);
        $listaMultimedia = $concepto->getMultimedias();
        $listaMime = array();
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach($listaMultimedia as $multim){
            //$file = new UploadedFile($multim->getWebPath(), $multim->getPath());
            $tipo = finfo_file($finfo, $multim->getWebPath());
            //$tipo = $file->getMimeType();
            array_push($listaMime, $tipo);
        }
        
        
        return $this->render('ProyectoSecurityBundle:Multimedia:listarArchivos.html.twig',array(
            'listaMultimedia' => $listaMultimedia,
            'idConcepto' =>$idConcepto,
            'listaMime' =>$listaMime
        ));
    }
    
    public function eliminarAction($idConcepto, $idMultimedia){
        $em = $this->getDoctrine()->getManager();
        $multimedia = $em->getRepository("ProyectoSecurityBundle:Multimedia")->find($idMultimedia);
        $em->remove($multimedia);
        $em->flush();
        
        return $this->redirect(
            $this->generateUrl('editar_concepto', array('idConcepto' => $idConcepto))
        );
    }
    
    public function selectAction(){
        $em = $this->getDoctrine()->getManager();
        $multimedias = $em->getRepository("ProyectoSecurityBundle:Multimedia")->findAll();
        $multimedia = new Multimedia();
        $form = $this->createForm(new MultimediaType(), $multimedia);  
        return $this->render('ProyectoSecurityBundle:Multimedia:listaNombres.html.twig', array(
            'form' => $form->createView(),
            'data' => $multimedias,
        ));
    }
}

