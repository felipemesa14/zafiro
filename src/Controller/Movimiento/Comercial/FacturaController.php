<?php

namespace App\Controller\Movimiento\Comercial;

use App\Controller\Administracion\Item\ItemController;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objFuncion = new Funciones();
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
            'codigoEmpresaFk' => $this->getUser()->getCodigoEmpresaFk()));
        return $this->render('Movimiento/Comercial/Factura/lista.html.twig', array(
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/nuevo/{codigoMovimiento}", name="zaf_ingreso_factura_nuevo")
     * @param Request $request
     * @param $codigoMovimiento
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function nuevoAction(Request $request, $codigoMovimiento)
    {
        $em = $this->getDoctrine()->getManager();
        $objFunciones = new Funciones();
        $arMovimiento = new Movimiento();
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
                $arEmpresa = $arTercero->getEmpresaRel();
                $arMovimiento->setEmpresaRel($arEmpresa);
                $arMovimiento->setMovimientoTipoRel($arMovimientoTipo);
                $em->persist($arMovimiento);
                $em->flush();
                return $this->redirectToRoute('zaf_ingreso_factura_detalle', array('codigoMovimiento' => $arMovimiento->getCodigoMovimientoPk()));
            } else {
                $objFunciones->Mensaje("error", "No existe el tercero.");
            }
        }
        return $this->render('Movimiento/Comercial/Factura/nuevo.html.twig', array(
            'arMovimiento' => $arMovimiento,
            'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/detalle/{codigoMovimiento}", name="zaf_ingreso_factura_detalle")
     * @param Request $request
     * @param $codigoMovimiento
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function detalleAction(Request $request, $codigoMovimiento)
    {
        $em = $this->getDoctrine()->getManager();
        $arMovimiento = $em->getRepository('App:Movimiento')->find($codigoMovimiento);
        $form = $this->formularioDetalle($arMovimiento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository('App:MovimientoDetalle')->eliminar($arrSeleccionados);
                return $this->redirectToRoute('zaf_ingreso_factura_detalle', array('codigoMovimiento' => $codigoMovimiento));
            }
            if ($form->get('BtnActualizar')->isClicked()) {
                $arrControles = $request->request->All();
                $this->actualizarDetalle($arrControles, $codigoMovimiento);
            }
            if ($form->get('BtnAutorizar')->isClicked()) {
                if (!$arMovimiento->getEstadoAutorizado()) {
                    $arMovimiento->setEstadoAutorizado(true);
                    $em->persist($arMovimiento);
                    $em->flush();
                    return $this->redirectToRoute("zaf_ingreso_factura_detalle", ['codigoMovimiento' => $codigoMovimiento]);
                }
            }
            if ($form->get('BtnDesAutorizar')->isClicked()) {
                if ($arMovimiento->getEstadoAutorizado()) {
                    $arMovimiento->setEstadoAutorizado(false);
                    $em->persist($arMovimiento);
                    $em->flush();
                    return $this->redirectToRoute("zaf_ingreso_factura_detalle", ['codigoMovimiento' => $codigoMovimiento]);
                }
            }
            if ($form->get('BtnAnular')->isClicked()) {
                if ($arMovimiento->getEstadoAutorizado()) {
                    $em->getRepository("App:Movimiento")->anular($arMovimiento);
                    return $this->redirectToRoute("zaf_ingreso_factura_detalle", ['codigoMovimiento' => $codigoMovimiento]);
                }
            }
            if ($form->get('BtnImprimir')->isClicked()) {

            }
        }
        return $this->render('Movimiento/Comercial/Factura/detalle.html.twig', array(
            'arMovimiento' => $arMovimiento,
            'form' => $form->createView()));
    }

    /**
     * @Route("/ingreso/factura/detalle/nuevo/item/{codigoMovimiento}", name="zaf_ingreso_factura_detalle_nuevo_item")
     * @param Request $request
     * @param $codigoMovimiento
     * @return \Symfony\Component\HttpFoundation\Response
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
                if ($arrSeleccionados) {
                    try {
                        $arMovimiento = $em->getRepository("App:Movimiento")->find($codigoMovimiento);
                        foreach ($arrSeleccionados as $seleccionado) {
                            $arItem = $em->getRepository("App:Item")->find($seleccionado);
                            $arMovimientoDetalle = new MovimientoDetalle();
                            $arMovimientoDetalle->setMovimientoRel($arMovimiento);
                            $arMovimientoDetalle->setItemRel($arItem);
                            $arMovimientoDetalle->setCantidad($request->request->get("TxtCantidad{$seleccionado}"));
                            $arMovimientoDetalle->setPorDescuento($request->request->get("TxtDescuento{$seleccionado}"));
                            $arMovimientoDetalle->setVrPrecio($request->request->get("TxtPrecio{$seleccionado}"));
                            $arMovimientoDetalle->setPorIva($request->request->get("TxtPorcentaje{$seleccionado}"));
                            $em->persist($arMovimientoDetalle);
                        }
                        $em->flush();
                        $em->getRepository("App:MovimientoDetalle")->liquidar($codigoMovimiento);
                        echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                    } catch (\Exception $exception) {
                        $objFuncion->Mensaje("error", "Ocurrio un error al momento de guardar el registro.");
                    }
                }
            }
        }
        //Consultar los item de la empresa
        $arItems = $this->listaItem();
        return $this->render('Movimiento/Comercial/Factura/detalleNuevoItem.html.twig', array(
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

    /**
     * @param $arMovimiento Movimiento
     * @return \Symfony\Component\Form\FormInterface
     */
    private function formularioDetalle($arMovimiento)
    {
        $arrBtnImprimir = ['label' => "Imprimir", "disabled" => true];
        $arrBtnAutorizar = ['label' => "Autorizar", "disabled" => false];
        $arrBtnDesAutorizar = ['label' => "Desautorizar", "disabled" => true];
        $arrBtnActualizar = ['label' => "Actualizar", "disabled" => false];
        $arrBtnEliminar = ['label' => "Eliminar", "disabled" => false];
        $arrBtnAnular = ['label' => "Anular", "disabled" => true];
        if ($arMovimiento->getEstadoAutorizado()) {
            $arrBtnActualizar['disabled'] = true;
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnDesAutorizar['disabled'] = false;
            $arrBtnImprimir['disabled'] = false;
            $arrBtnAnular['disabled'] = false;
        }
        if ($arMovimiento->getEstadoAnulado()) {
            $arrBtnDesAutorizar['disabled'] = true;
            $arrBtnAnular['disabled'] = true;
            $arrBtnImprimir['disabled'] = false;
        }

        $form = $this->createFormBuilder()
            ->add('BtnImprimir', SubmitType::class, $arrBtnImprimir)
            ->add('BtnAutorizar', SubmitType::class, $arrBtnAutorizar)
            ->add('BtnDesAutorizar', SubmitType::class, $arrBtnDesAutorizar)
            ->add('BtnAnular', SubmitType::class, $arrBtnAnular)
            ->add('BtnEliminar', SubmitType::class, $arrBtnEliminar)
            ->add('BtnActualizar', SubmitType::class, $arrBtnActualizar)
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
            $this->getUser()->getCodigoEmpresaFk(),
            $session->get('filtroNombreItem'),
            $session->get('filtroReferenciaItem'));
        return $arItem;
    }

    public function actualizarDetalle($arrControles, $codigoMovimiento)
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($arrControles['LblCodigo'])) {
            foreach ($arrControles['LblCodigo'] as $codigo) {
                $arMovimientoDetalle = $em->getRepository("App:MovimientoDetalle")->find($codigo);
                $cantidad = $arrControles["TxtCantidad{$codigo}"];
                $vrPrecio = $arrControles["TxtPrecio{$codigo}"];
                $descuento = $arrControles["TxtDescuento{$codigo}"];
                $iva = ($arrControles["TxtPorcentaje{$codigo}"] == '') ? 0 : $arrControles["TxtPorcentaje{$codigo}"];
                $arMovimientoDetalle->setCantidad($cantidad);
                $arMovimientoDetalle->setVrPrecio($vrPrecio);
                $arMovimientoDetalle->setPorIva($iva);
                $arMovimientoDetalle->setPorDescuento($descuento);
                $em->persist($arMovimientoDetalle);
            }
            $em->flush();
            $em->getRepository("App:MovimientoDetalle")->liquidar($codigoMovimiento);
        }
    }

}
