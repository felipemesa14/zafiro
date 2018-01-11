<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\FacturaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FacturaController extends Controller {

    /**
     * @Route("/ingreso/factura/lista", name="zaf_ingreso_factura_lista")
     */
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $codigoEmpresa = 1; // esta variable se debe consultar con la entidad del usuario que tiene relacion con la empresa
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:Movimiento')->eliminar($arrSeleccionados);
                if ($strRespuesta != "") {
                    $strRespuesta;
                }
                return $this->redirectToRoute('zaf_ingreso_factura_lista');
            }
        }
        //Consultar los movimientos de tipo factura
        $arMovimientos = $em->getRepository('App:Movimiento')->findBy(array(
            'codigoMovimientoTipoFk' => 1,
            'codigoEmpresaFk' => $codigoEmpresa));
        return $this->render('Factura/lista.html.twig', array(
                    'arMovimientos' => $arMovimientos,
                    'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/nuevo/{codigoMovimiento}", name="zaf_ingreso_factura_nuevo")
     */
    public function nuevoAction(Request $request, $codigoMovimiento) {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $em->getRepository('App:Empresa')->find(1);// empresa del usuario logeado
        $arMovimiento = new \App\Entity\Movimiento();
        $arMovimiento->setFecha(new \DateTime('now'));
        $arMovimiento->setFechaVencimiento(new \DateTime('now'));
        if ($codigoMovimiento != 0) {
            $arMovimiento = $em->getRepository('App:Movimiento')->find($codigoMovimiento);
        }
        $form = $this->createForm(FacturaType::class, $arMovimiento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arMovimiento = $form->getData();
            $arrControles = $request->request->All();
            $numeroIdentificacion = $arrControles['form_txtNumeroIdentificacion'];
            $arTercero = $em->getRepository('App:Tercero')->findOneBy(array('numeroIdentificacion' => $numeroIdentificacion));
            if ($arTercero) {
                $arMovimientoTipo = $em->getRepository('App:MovimientoTipo')->find(1); //Tipo de movimiento factura de venta
                $arMovimiento->setTerceroRel($arTercero);
                $arMovimiento->setEmpresaRel($arEmpresa);
                $arMovimiento->setMovimientoTipoRel($arMovimientoTipo);
                $em->persist($arMovimiento);
                $em->flush();
                return $this->redirectToRoute('zaf_ingreso_factura_detalle', array('codigoMovimiento' => $arMovimiento->getCodigoMovimientoPk()));
            } else {
                $strRespuesta = "El tercero no existe";
            }
        }
        return $this->render('Factura/nuevo.html.twig', array(
                    'arMovimiento' => $arMovimiento,
                    'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/detalle/{codigoMovimiento}", name="zaf_ingreso_factura_detalle")
     */
    public function detalleAction(Request $request, $codigoMovimiento) {
        $em = $this->getDoctrine()->getManager();
        $arMovimiento = $em->getRepository('App:Movimiento')->find($codigoMovimiento);
        $arMovimientosDetalles = $em->getRepository('App:MovimientoDetalle')->findBy(array('codigoMovimientoFk' => $codigoMovimiento));
        return $this->render('Factura/detalle.html.twig', array(
                    'arMovimiento' => $arMovimiento,
                    'arMovimientosDetalles' => $arMovimientosDetalles));
    }

    private function formularioLista() {
        $form = $this->createFormBuilder()
                ->add('numero',NumberType::class)
                ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
                ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
                ->getForm();

        return $form;
    }

}
