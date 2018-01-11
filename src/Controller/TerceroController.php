<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\TerceroType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TerceroController extends Controller {

    /**
     * @Route("/admin/tercero/lista", name="zaf_admin_tercero_lista")
     */
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $codigoEmpresa = 1; // esta variable se debe consultar con la entidad del usuario que tiene relacion con la empresa
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:Tercero')->eliminar($arrSeleccionados);
                if ($strRespuesta != "") {
                    $strRespuesta;
                }
                return $this->redirectToRoute('zaf_admin_tercero_lista');
            }
        }
        //Consultar los tercero de la empresa
        $arTerceros = $em->getRepository('App:Tercero')->findBy(array(
            'codigoEmpresaFk' => $codigoEmpresa));
        return $this->render('Tercero/lista.html.twig', array(
                    'arTerceros' => $arTerceros,
                    'form' => $form->createView()));
    }

    /**
     * 
     * @Route("/admin/tercero/nuevo/{codigoTercero}", name="zaf_admin_tercero_nuevo")
     */
    public function nuevoAction(Request $request, $codigoTercero) {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $em->getRepository('App:Empresa')->find(1); //Consultar la empresa del usuario
        $arTercero = new \App\Entity\Tercero();
        if ($codigoTercero != 0) {
            $arTercero = $em->getRepository('App:Tercero')->find($codigoTercero);
        }
        $form = $this->createForm(TerceroType::class, $arTercero);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arTercero = $form->getData();
            $arTercero->setEmpresaRel($arEmpresa);
            $em->persist($arTercero);
            $em->flush();
            return $this->redirectToRoute('zaf_admin_tercero_detalle', array('codigoTercero' => $arTercero->getCodigoTerceroPk()));
        }
        return $this->render('Tercero/nuevo.html.twig', array(
                    'arTercero' => $arTercero,
                    'form' => $form->createView()
        ));
    }

    /**
     * 
     * @Route("/admin/tercero/detalle/{codigoTercero}", name="zaf_admin_tercero_detalle")
     */
    public function detalleAction(Request $request, $codigoTercero) {
        $em = $this->getDoctrine()->getManager();
        $arTercero = $em->getRepository('App:Tercero')->find($codigoTercero);
        return $this->render('Tercero/detalle.html.twig', array(
                    'arTercero' => $arTercero));
    }

    private function formularioLista() {
        $form = $this->createFormBuilder()
                ->add('nombre', TextType::class)
                ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
                ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
                ->getForm();

        return $form;
    }

}
