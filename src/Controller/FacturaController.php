<?php

namespace App\Controller;

use App\Funciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\FacturaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Session\Session;

class FacturaController extends Controller
{

    /**
     * @Route("/ingreso/factura/lista", name="zaf_ingreso_factura_lista")
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objFuncion = new Funciones();
        $session = new Session();
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:Movimiento')->eliminar($arrSeleccionados);
                if ($strRespuesta != "") {
                    $objFuncion->Mensaje('error', $strRespuesta);
                }
                return $this->redirectToRoute('zaf_ingreso_factura_lista');
            }
        }
        //Consultar los movimientos de tipo factura
        $arMovimientos = $em->getRepository('App:Movimiento')->findBy(array(
            'codigoMovimientoTipoFk' => 1,
            'codigoEmpresaFk' => $session->get('codigoEmpresa')));
        return $this->render('Factura/lista.html.twig', array(
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/nuevo/{codigoMovimiento}", name="zaf_ingreso_factura_nuevo")
     */
    public function nuevoAction(Request $request, $codigoMovimiento)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $session->get('arEmpresa');
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
    public function detalleAction(Request $request, $codigoMovimiento)
    {
        $objFuncion = new Funciones();
        $em = $this->getDoctrine()->getManager();
        $form = $this->formularioDetalle();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:MovimientoDetalle')->eliminar($arrSeleccionados);
                $strRespuesta != "" ? $objFuncion->Mensaje('error', $strRespuesta) : $em->flush();
                return $this->redirectToRoute('zaf_ingreso_factura_detalle', array('codigoMovimiento' => $codigoMovimiento));
            }
        }
        $arMovimiento = $em->getRepository('App:Movimiento')->find($codigoMovimiento);
        return $this->render('Factura/detalle.html.twig', array(
            'arMovimiento' => $arMovimiento,
            'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/detalle/nuevo/item/{codigoMovimiento}", name="zaf_ingreso_factura_detalle_nuevo_item")
     */
    public function detalleNuevoItemAction(Request $request, $codigoMovimiento)
    {
        $objFuncion = new Funciones();
        $objItem = new ItemController();
        $em = $this->getDoctrine()->getManager();
        $form = $this->formularioNuevoItem();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnFiltrar')->isClicked()) {
                $objItem->filtrar($form);
            }
            if ($form->get('BtnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:MovimientoDetalle')->nuevoFacturaDetalle($arrSeleccionados);
                if ($strRespuesta != "") {
                    $objFuncion->Mensaje('error', $strRespuesta);
                }
                return $this->redirectToRoute('zaf_ingreso_factura_detalle_nuevo_item');
            }
        }
        //Consultar los item de la empresa
        $arItems = $this->listaItem();
        return $this->render('Buscar/item.html.twig', array(
            'arItems' => $arItems,
            'form' => $form->createView()));

    }

    private function formularioLista()
    {
        $form = $this->createFormBuilder()
            ->add('numero', NumberType::class)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
            ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
            ->getForm();

        return $form;
    }

    private function formularioDetalle()
    {
        $form = $this->createFormBuilder()
            ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
            ->getForm();

        return $form;
    }

    public function formularioNuevoItem()
    {
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class)
            ->add('referencia', TextType::class)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
            ->add('BtnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();

        return $form;
    }

    public function listaItem()
    {
        $session = new Session();
        $em = $this->getDoctrine();
        $arItem = $em->getRepository("App:Item")->listaDql(
            $session->get('arEmpresa')->getCodigoEmpresaPk(),
            $session->get('filtroNombreItem'),
            $session->get('filtroReferenciaItem'));
        return $arItem;
    }

}
